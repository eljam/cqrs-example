<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DoctrineExportMappingCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDefinition([])
            ->setName('app:doctrine:export-mapping')
            ->setDescription(
                'This command allows to show the mapping of one or all tables'
            )
            ->addOption(
                'include',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY
            )
            ->addOption(
                'exclude',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY
            )
            ->addOption(
                'img',
                null,
                InputOption::VALUE_REQUIRED,
                'Output as a graph in the given image file'
            )
            ->addOption(
                'with-fields',
                null,
                InputOption::VALUE_NONE
            )
            ->addOption(
                'with-packages',
                null,
                InputOption::VALUE_NONE
            )
            ->addOption(
                'sql-names',
                null,
                InputOption::VALUE_NONE
            )
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var array $include */
        $include = $input->getOption('include');
        /** @var array $exclude */
        $exclude   = $input->getOption('exclude');
        $outputImg = $input->getOption('img');

        $table            = new Table($output);
        $documentMappings = [];
        /** @var \Doctrine\ORM\Mapping\ClassMetadataInfo $classMetadata */
        foreach ($this->getEntityManager()->getMetadataFactory()->getAllMetadata() as $classMetadata) {
            $name = self::cleanEntityName($classMetadata->getName());

            if (\count($include) > 0) {
                $found = false;
                foreach ($include as $i) {
                    if (false !== \stripos($name, $i)) {
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    continue;
                }
            }

            if (\count($exclude) > 0) {
                $found = false;
                foreach ($exclude as $i) {
                    if (false !== \stripos($name, $i)) {
                        $found = true;
                        break;
                    }
                }

                if ($found) {
                    continue;
                }
            }

            $output->writeln(\sprintf(
                "'%s' entity: %s",
                $name,
                !$classMetadata->getFieldNames() ? ' no fields' : ''
            ));

            if (!$classMetadata->getFieldNames()) {
                continue;
            }

            $table->setHeaders([
                'Field',
                'Type',
                'Ref',
            ]);

            $documentMappings[$name] = [
            'name'        => $name,
            'table_name'  => $classMetadata->getTableName(),
            'partitioned' => false,
            'label'       => self::removePackage($name),
            'class'       => $classMetadata->getName(),
            'parent'      => $classMetadata->parentClasses ? self::cleanEntityName($classMetadata->parentClasses[0]) : null, //php_cs:ignore
            'ns'          => \substr($classMetadata->getName(), 0, \strrpos($classMetadata->getName(), '\\') - 1), //php_cs:ignore
            'fields'      => $this->getFieldsMapping($classMetadata),
            ];

            foreach ($documentMappings[$name]['fields'] as $field => $data) {
                $table->addRow([
                    $field,
                    $data['type'],
                    $data['fk'],
                ]);
            }

            if (!$outputImg) {
                $table->render();
            }
        }

        if ($outputImg) {
            $this->renderSchema(
                $outputImg,
                $documentMappings,
                $input->getOption('with-fields'),
                $input->getOption('with-packages'),
                $input->getOption('sql-names')
            );
        }
    }

    private function renderSchema(
        $outputImg,
        $documentMappings,
        $showFields = false,
        $showPackages = false,
        $useSqlNames = false
    ) {
        $out   = [];
        $out[] = <<<EOS
digraph g {

//ratio=auto
rankdir=BT

graph [
    bgcolor="#e0e0e0"
    concentrate = true
];

node [
    fontname=Arial
    fontcolor="#484848"
    fontsize=10
    shape="plaintext"
];

edge [
    pencolor="#ff0000"
];

EOS;
        /** @var array $packages */
        $packages = [];
        foreach ($documentMappings as $mapping) {
            /** @var string $packageName */
            $packageName = \str_replace('\\', '/', $mapping['ns']);
            if (!isset($packages[$packageName])) {
                $packages[$packageName] = [];
            }

            $packages[$packageName][] = $mapping;
        }

        $packageTree = self::unflatten($packages, '/');
        $out[]       = $this->renderPackageTree($packageTree, $showFields, $showPackages, $useSqlNames);

        foreach ($documentMappings as $mapping) {
            if (null !== $mapping['parent']) {
                $out[] = \sprintf(
                    '"%s" -> "%s" [arrowhead="onormal"]',
                    $mapping['name'],
                    $mapping['parent']
                );
            }

            foreach ($mapping['fields'] as $fieldName => $fieldData) {
                if ($fieldData['fk']) {
                    $out[] = \sprintf(
                        '"%s" -> "%s" [arrowhead="odiamond"]',
                        $fieldData['fk'],
                        $mapping['name']
                    );
                }
            }
        }

        $out[] = '}';

        \file_put_contents($outputImg.'.dot', \implode(PHP_EOL, $out));

        \shell_exec(\sprintf(
            'unflatten -l 3 -c 5 -o %s.dot.uf %s.dot',
            $outputImg,
            $outputImg
        ));

        \shell_exec(\sprintf(
            'dot -T%s -o %s %s.dot.uf',
            \pathinfo($outputImg, PATHINFO_EXTENSION),
            $outputImg,
            $outputImg
        ));

        \shell_exec(\sprintf(
            'rm -f %s.dot %s.dot.*',
            $outputImg,
            $outputImg
        ));
    }

    /**
     * @param array $packageTree
     * @param bool  $showFields
     * @param bool  $showPackages
     * @param bool  $useSqlNames
     *
     * @return string
     */
    private function renderPackageTree(
        array $packageTree,
        $showFields = false,
        $showPackages = false,
        $useSqlNames = false
    ) {
        static $clusterSeq = 0;

        $out = [];

        foreach ($packageTree as $k => $mapping) {
            if (!\is_int($k)) {
                continue;
            }

            $tableColor  = $mapping['partitioned'] ? '#adff2f' : '#b8860b';
            $headerColor = $mapping['partitioned'] ? '#6495ed' : '#d2691e';

            $html = <<<EOS
<table border="0" bgcolor="$tableColor" cellborder="1" cellpadding="2" cellspacing="0" align="left">
EOS;

            $html .= '<tr><td bgcolor="'.$headerColor.'" colspan="2"><font point-size="14"><b>'
                .($useSqlNames ? $mapping['table_name'] : $mapping['label'])
                .'</b></font></td></tr>';

            if ($showFields) {
                foreach ($mapping['fields'] as $fieldName => $fieldData) {
                    $html .= '<tr><td>'
                        .($useSqlNames ? $fieldData['column_name'] : $fieldName)
                        .'</td><td>'
                        .$fieldData['type']
                        .'</td></tr>';
                }
            }

            $html .= '</table>';

            $out[] = \sprintf(
                '"%s" [label=<%s>]',
                $mapping['name'],
                $html
            );
        }

        foreach ($packageTree as $packageName => $children) {
            if (\is_int($packageName)) {
                continue;
            }

            if ($showPackages) {
                ++$clusterSeq;
                $color = $this->generateColorCode($packageName);
                $out[] = <<<EOS
subgraph cluster_$clusterSeq {
    label="$packageName";
    style=filled;
    color="$color";
EOS;
            }

            $out[] = $this->renderPackageTree($children, $showFields, $showPackages, $useSqlNames);

            if ($showPackages) {
                $out[] = '}';
            }
        }

        return \implode(PHP_EOL, $out);
    }

    /**
     * @param ClassMetadataInfo $classMetadata
     *
     * @return array
     *
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    private function getFieldsMapping(ClassMetadataInfo $classMetadata)
    {
        $fields = ['id' => null];
        foreach ($classMetadata->getAssociationNames() as $field) {
            if ($classMetadata->isInheritedField($field)) {
                continue;
            }

            $mapping = $classMetadata->getAssociationMapping($field);
            if (!$mapping['isOwningSide']) {
                continue;
            }

            $fields[$field] = [
                'type'        => 'integer',
                'column_name' => $classMetadata->getColumnName($field),
                'fk'          => self::cleanEntityName($classMetadata->getAssociationTargetClass($field)),
            ];
        }

        foreach ($classMetadata->getFieldNames() as $field) {
            if ($classMetadata->isInheritedField($field)) {
                continue;
            }

            $mapping = $classMetadata->getFieldMapping($field);
            $type    = $mapping['type'];

            $fields[$field] = [
                'type'        => $type,
                'column_name' => $classMetadata->getColumnName($field),
                'fk'          => null,
            ];
        }

        return $fields;
    }

    private function generateColorCode($seed)
    {
        $hex = (int) \hexdec(\substr(\md5($seed), 0, 16));
        \mt_srand($hex);

        $color = [];
        for ($i = 0; $i < 3; ++$i) {
            $color[$i] = \sprintf(
                '%02x',
                208 + \mt_rand(0, 47)
            );
        }

        return '#'.\implode('', $color);
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param array  $array
     * @param string $separator
     *
     * @return array
     */
    private static function unflatten(array $array, $separator = '.')
    {
        $a = [];
        foreach ($array as $k => $v) {
            /** @var array $path */
            $path = \explode($separator, $k);
            $last = \array_pop($path);
            $cur  = &$a;
            foreach ($path as $field) {
                if (!isset($cur[$field])) {
                    $cur[$field] = [];
                }

                $cur = &$cur[$field];
            }

            $cur[$last] = $v;
        }

        return $a;
    }

    /**
     * @param string $docName
     *
     * @return string
     */
    private static function cleanEntityName(string $docName)
    {
        /** @var string $docName */
        $docName = (string) \str_replace('Socloz\\', '', $docName);
        $docName = (string) \preg_replace('~(.*Bundle\\\\)Entity\\\\~', '\1', $docName);
        $docName = (string) \str_replace('\\', ':', $docName);

        return $docName;
    }

    private static function removePackage($className)
    {
        return \basename(\str_replace(':', '/', $className));
    }
}
