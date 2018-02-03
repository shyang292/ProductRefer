<?php

/**
 * Mageprince
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @package Abm_ProductRefer
 */

namespace Abm\ProductRefer\Block\Adminhtml\ProductRefer\Edit\Tab;

use Magento\Catalog\Helper\Category;

/**
 * Class Main
 * @package Abm\ProductRefer\Block\Adminhtml\ProductRefer\Edit\Tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    private $systemStore;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Group\Collection
     */
    private $customerCollection;


    /**
     * Tony add
     */

    protected $_categoryHelper;
    protected $categoryRepository;
    protected $categoryList;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Customer\Model\ResourceModel\Group\Collection $customerCollection,

        \Magento\Catalog\Helper\Category $catalogCategory,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        array $data = []
    ) {
        $this->systemStore = $systemStore;
        $this->customerCollection = $customerCollection;

        $this->_categoryHelper = $catalogCategory;
        $this->categoryRepository = $categoryRepository;

        parent::__construct($context, $registry, $formFactory, $data);
    }


    /**
     * -----------------------------------------
     */
    /*
     * Return categories helper
     */

    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted , $asCollection, $toLoad);
    }

    /*
     * Option getter
     * @return array
     */
    public function toOptionArray()
    {


        $arr = $this->toArraya();
        $ret = [];

        foreach ($arr as $key => $value)
        {

            $ret[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        return $ret;
    }

    /*
     * Get options in "key-value" format
     * @return array
     */
    public function toArraya()
    {

        $categories = $this->getStoreCategories(true,false,true);
        $categoryList = $this->renderCategories($categories);
        return $categoryList;
    }

    public function renderCategories($_categories)
    {
        foreach ($_categories as $category){
            $i = 0;
            $this->categoryList[$category->getEntityId()] = __($category->getName());   // Main categories
            $list = $this->renderSubCat($category,$i);
        }

        return $this->categoryList;
    }

    public function renderSubCat($cat,$j){

        $categoryObj = $this->categoryRepository->get($cat->getId());

        $level = $categoryObj->getLevel();
        $arrow = str_repeat("---", $level-1);
        $subcategories = $categoryObj->getChildrenCategories();

        foreach($subcategories as $subcategory) {
            $this->categoryList[$subcategory->getEntityId()] = __($arrow.$subcategory->getName());

            if($subcategory->hasChildren()) {

                $this->renderSubCat($subcategory,$j);

            }
        }

        return $this->categoryList;
    }
    /**
     * --------------------------------------
     */


    /**
     * Prepare form
     *
     * @return $this
     */
    public function _prepareForm()
    {
        
        $model = $this->_coreRegistry->registry('productrefer');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Abm_ProductRefer::save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('productrefer_main_');

        $fieldset = $form->addFieldset('base_fieldset',
            ['legend' => __('References Information')]
        );

        $customerGroup = $this->customerCollection->toOptionArray();

        if ($model->getId()) {
            $fieldset->addField('productrefer_id', 'hidden', ['name' => 'productrefer_id']);
        }

        $fieldset->addField(
            'lastname',
            'text',
            [
                'name' => 'lastname',
                'label' => __('Lastname'),
                'title' => __('Lastname'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'initialsname',
            'text',
            [
                'name' => 'initialsname',
                'label' => __('Initialsname'),
                'title' => __('Initialsname'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'article',
            'text',
            [
                'name' => 'article',
                'label' => __('Article'),
                'title' => __('Article'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'journal',
            'text',
            [
                'name' => 'journal',
                'label' => __('Journal'),
                'title' => __('Journal'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'issue',
            'text',
            [
                'name' => 'issue',
                'label' => __('Issue'),
                'title' => __('Issue'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'pages',
            'text',
            [
                'name' => 'pages',
                'label' => __('Pages'),
                'title' => __('Pages'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'year',
            'text',
            [
                'name' => 'year',
                'label' => __('Year'),
                'title' => __('Year'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'application',
            'text',
            [
                'name' => 'application',
                'label' => __('Application'),
                'title' => __('Application'),
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'pubmed',
            'text',
            [
                'name' => 'pubmed',
                'label' => __('Pubmed'),
                'title' => __('Pubmed'),
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'doi',
            'text',
            [
                'name' => 'doi',
                'label' => __('Doi'),
                'title' => __('Doi'),
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addType(
            'categories',
            '\Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Category');

//
//        $fieldset->addField(
//            'customer_group',
//            'multiselect',
//            [
//                'name' => 'customer_group[]',
//                'label' => __('Customer Group'),
//                'title' => __('Customer Group'),
//                'required' => true,
//                'value' => [0,1,2,3],
//                'values' => $customerGroup,
//                'disabled' => $isElementDisabled
//            ]
//        );

        $fieldset->addField(
            'category_group',
            'multiselect',
            [
                'name' => 'category_group[]',
                'label' => __('Category Group'),
                'title' => __('Category Group'),
                'values' => $this->toOptionArray(),
            ]
        );
//
//        $fieldset->addField(
//            'store',
//            'multiselect',
//            [
//                'name' => 'store[]',
//                'label' => __('Store'),
//                'title' => __('Store'),
//                'required' => true,
//                'value' => [0,1],
//                'values' => $this->systemStore->getStoreValuesForForm(false, true),
//                'disabled' => $isElementDisabled
//            ]
//        );

        $fieldset->addField(
            'active',
            'select',
            [
                'name' => 'active',
                'label' => __('Active'),
                'title' => __('Active'),
                'value' => 1,
                'options' => ['1' => __('Yes'), '0' => __('No')],
                'disabled' => $isElementDisabled
            ]
        );

        $this->_eventManager->dispatch('adminhtml_productrefer_edit_tab_main_prepare_form', ['form' => $form]);

        if ($model->getId()) {
            $form->setValues($model->getData());
        }
        
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('References Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('References Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    public function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
