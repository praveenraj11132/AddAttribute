<?php

namespace Wheelpros\ProductMapping\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Eav\Api\Data\AttributeGroupInterfaceFactory;
use Magento\Eav\Api\Data\AttributeGroupInterface;
use Magento\Eav\Api\AttributeGroupRepositoryInterface;
use Magento\Eav\Api\AttributeManagementInterface;

/**
 * Data patch class to add custom product attributes
 */
class AddProductAttributes implements DataPatchInterface, PatchRevertableInterface
{

    private const DEFAULT_ATTR_SET_ID = 4;

    /**
     * Custom attributes data
     *
     * @var array
     */
    private array $attributes = [
        'upc' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'UPC',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'inventory_type' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Inventory Type',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'model' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Model',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'offset' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Offset',
            'input' => 'text',
            'class' => '',
            'source' => '',
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'default' => '',
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => false,
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'bolt_pattern' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Bolt Pattern',
            'input' => 'text',
            'class' => '',
            'source' => '',
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'default' => '',
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => false,
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'finish_code' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Finish Code',
            'input' => 'text',
            'class' => '',
            'source' => '',
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'default' => '',
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => false,
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'finish' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'PO Finish',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'wheel_width' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Wheel Width',
            'input' => 'text',
            'class' => '',
            'source' => '',
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'default' => '',
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => false,
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'wheel_diameter' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Wheel Diameter',
            'input' => 'text',
            'class' => '',
            'source' => '',
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'default' => '',
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => false,
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'bore' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Bore',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'backspacing' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Backspace',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'wheel_weight' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Wheel Weight',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'cap_part_number' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Cap Part Number',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'rivet_part_number' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Rivet Part Number',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'tpms_compatible' => [
            'type' => 'int',
            'backend' => '',
            'frontend' => '',
            'label' => 'TPMS Compatible',
            'input' => 'boolean',
            'class' => '',
            'source' => Boolean::class,
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'default' => 0,
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'lip_depth' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Lip Depth',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'certification' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Certification',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'structural_warranty' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Structural Warranty',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'finish_warranty' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Finish Warranty',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'open_end_cap_number' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Open End Cap Number',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'cap_screw_number' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Cap Screw Number',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'other_accessories' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Other Accessories',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'additional_accessories' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Additional Accessories',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'catalogue_page' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Catalogue Page',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'load_rating' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Load Rating',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'size_description' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Size Description',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'unit_of_measure' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Unit of Measure',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'shipping_weight' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Shipping Weight',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'division' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Division',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'international_article_number' => [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'International Article Number',
            'input' => 'text',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'cross_plant_start_date' => [
            'type' => 'datetime',
            'backend' => '',
            'frontend' => '',
            'label' => 'Cross Plant Start Date',
            'input' => 'date',
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
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
        'product_taxable' => [
            'type' => 'int',
            'backend' => '',
            'frontend' => '',
            'label' => 'Product Taxable',
            'input' => 'boolean',
            'class' => '',
            'source' => Boolean::class,
            'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'default' => 0,
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_in_product_listing' => false,
            'unique' => false,
            'apply_to' => ''
        ],
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
        AttributeManagementInterface      $attributeManagement
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeGroupInterfaceFactory = $attributeGroupInterfaceFactory;
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->attributeManagement = $attributeManagement;
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

        $attributeGroupId = $this->createAttributeGroup();
        $initialSortOrder = 100;

        foreach ($this->attributes as $attributeCode => $attribute) {
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

    /**
     * Rollback changes
     *
     * @return void
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        foreach ($this->attributes as $attributeCode => $attribute) {
            $eavSetup->removeAttribute(Product::ENTITY, $attributeCode);
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Create new attribute group
     *
     * @return string
     * @throws NoSuchEntityException
     * @throws StateException
     */
    private function createAttributeGroup()
    {
        /** @var AttributeGroupInterface $attributeGroup */
        $attributeGroup = $this->attributeGroupInterfaceFactory->create();
        $attributeGroup->setAttributeGroupName('Additional Attributes');
        $attributeGroup->setAttributeSetId(self::DEFAULT_ATTR_SET_ID);
        return $this->attributeGroupRepository->save($attributeGroup)->getAttributeGroupId();
    }
}
