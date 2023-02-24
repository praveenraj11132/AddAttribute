<?php

namespace Wheelpros\ProductMapping\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Api\Data\AttributeGroupInterfaceFactory;
use Magento\Eav\Api\AttributeGroupRepositoryInterface;
use Magento\Eav\Api\AttributeManagementInterface;
use Magento\Catalog\Model\Config;
/**
 * Data patch class to add custom product attributes
 */
class BrandAttribute implements DataPatchInterface
{

    private const DEFAULT_ATTR_SET_ID = 4;

    private $config;


    /**
     * Custom attributes data
     *
     * @var array
     */
    private array $attributes = [
        'brand' => [
            'type' => 'int',
            'backend' => '',
            'frontend' => '',
            'label' => 'Brand',
            'input' => 'select',
            'class' => '',
            'source' => '',
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_for_promo_rules' => true,
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => '',
            'option' => [
                'values' => [
                    'MRF',
                    'CEAT',
                ]
            ],
        ]

    ];

    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;
    /**
     * @var EavSetupFactory
     */
    private EavSetupFactory $eavSetupFactory;
    /**
     * @var AttributeGroupInterfaceFactory
     */
    private AttributeGroupInterfaceFactory $attributeGroupInterfaceFactory;
    /**
     * @var AttributeGroupRepositoryInterface
     */
    private AttributeGroupRepositoryInterface $attributeGroupRepository;
    /**
     * @var AttributeManagementInterface
     */
    private AttributeManagementInterface $attributeManagement;

    /**
     * @param ModuleDataSetupInterface          $moduleDataSetup
     * @param EavSetupFactory                   $eavSetupFactory
     * @param AttributeGroupInterfaceFactory    $attributeGroupInterfaceFactory
     * @param AttributeGroupRepositoryInterface $attributeGroupRepository
     * @param AttributeManagementInterface      $attributeManagement
     */
    public function __construct(
        ModuleDataSetupInterface          $moduleDataSetup,
        EavSetupFactory                   $eavSetupFactory,
        AttributeGroupInterfaceFactory    $attributeGroupInterfaceFactory,
        AttributeGroupRepositoryInterface $attributeGroupRepository,
        AttributeManagementInterface      $attributeManagement,
        Config                            $config
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeGroupInterfaceFactory = $attributeGroupInterfaceFactory;
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->attributeManagement = $attributeManagement;
        $this->config = $config;
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * Add product attributes
     *
     * @return void
     * @throws LocalizedException
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $attributeGroupId = $this->config->getAttributeGroupId(self::DEFAULT_ATTR_SET_ID,"Additional Attributes");
        $initialSortOrder = 100;

        foreach ($this->attributes as $attributeCode => $attribute) {
            $eavSetup->removeAttribute(Product::ENTITY,$attributeCode);
            // Create Attribute
            $eavSetup->addAttribute(
                Product::ENTITY,
                $attributeCode,
                $attribute
            );

            // Assign each attribute to attribute group in default attribute set
            $this->attributeManagement->assign(
                Product::ENTITY,
                self::DEFAULT_ATTR_SET_ID,
                $attributeGroupId,
                $attributeCode,
                $initialSortOrder
            );

            $initialSortOrder += 10;
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
