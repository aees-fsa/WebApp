<?php
/**
 * Copyright (C) 2020 Andrew SASSOYE
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, version 3.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

namespace AppBundle\Block;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\CoreBundle\Model\ManagerInterface;
use Sonata\MediaBundle\Admin\BaseMediaAdmin;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Templating\EngineInterface;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class SliderBlockService extends AbstractAdminBlockService
{
    /**
     * @var BaseMediaAdmin
     */
    protected $mediaAdmin;

    /**
     * @var ManagerInterface
     */
    protected $mediaManager;

    /**
     * @param string             $name
     * @param EngineInterface    $templating
     * @param ContainerInterface $container
     * @param ManagerInterface   $mediaManager
     */
    public function __construct($name, EngineInterface $templating, ContainerInterface $container, ManagerInterface $mediaManager)
    {
        parent::__construct($name, $templating);

        $this->mediaManager = $mediaManager;
        $this->container = $container;
    }

    /**
     * @return Pool
     */
    public function getMediaPool()
    {
        return $this->getMediaAdmin()->getPool();
    }

    /**
     * @return BaseMediaAdmin
     */
    public function getMediaAdmin()
    {
        if (!$this->mediaAdmin) {
            $this->mediaAdmin = $this->container->get('sonata.media.admin.media');
        }

        return $this->mediaAdmin;
    }

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'media' => false,
            'context' => false,
            'mediaId' => null,
            'rawContent' => '<h1>Titre</h1><h2>Description</h2><a href="#">Plus d\'info</a>',
            'content' => '<h1>Titre</h1><h2>Description</h2><a href="#">Plus d\'info</a>',
            'format' => false,
            'template' => 'AppBundle:Block:block_slider.html.twig',

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        if (!$block->getSetting('mediaId') instanceof MediaInterface) {
            $this->load($block);
        }

        // NEXT_MAJOR: Keep FQCN when bumping Symfony requirement to 2.8+.
        if (method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            $immutableArrayType = 'Sonata\CoreBundle\Form\Type\ImmutableArrayType';
            $textType = 'Symfony\Component\Form\Extension\Core\Type\TextType';
            $choiceType = 'Symfony\Component\Form\Extension\Core\Type\ChoiceType';
        } else {
            $immutableArrayType = 'sonata_type_immutable_array';
            $textType = 'text';
            $choiceType = 'choice';
        }


        $formMapper->add('settings', $immutableArrayType, array(
            'keys' => array(
                array($this->getMediaBuilder($formMapper), null, array()),
                array('content', 'sonata_formatter_type', function (FormBuilderInterface $formBuilder) {
                    return array(
                        'event_dispatcher' => $formBuilder->getEventDispatcher(),
                        'format_field' => array('format', '[format]'),
                        'source_field' => array('rawContent', '[rawContent]'),
                        'target_field' => '[content]',
                        'label' => 'form.label_content',
                        'ckeditor_context' => 'slider',
                    );
                }),
            ),
            'translation_domain' => 'SonataMediaBundle',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function load(BlockInterface $block)
    {
        $media = $block->getSetting('mediaId', null);

        if (is_int($media)) {
            $media = $this->mediaManager->findOneBy(array('id' => $media));
        }

        $block->setSetting('mediaId', $media);
    }

    /**
     * @param FormMapper $formMapper
     *
     * @return FormBuilder
     */
    protected function getMediaBuilder(FormMapper $formMapper)
    {
        // simulate an association ...
        $fieldDescription = $this->getMediaAdmin()->getModelManager()->getNewFieldDescriptionInstance($this->mediaAdmin->getClass(), 'media', array(
            'translation_domain' => 'SonataMediaBundle',
        ));
        $fieldDescription->setAssociationAdmin($this->getMediaAdmin());
        $fieldDescription->setAdmin($formMapper->getAdmin());
        $fieldDescription->setOption('edit', 'list');
        $fieldDescription->setAssociationMapping(array(
            'fieldName' => 'media',
            'type' => ClassMetadataInfo::MANY_TO_ONE,
        ));

        // NEXT_MAJOR: Keep FQCN when bumping Symfony requirement to 2.8+.
        $modelListType = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')
            ? 'Sonata\AdminBundle\Form\Type\ModelListType'
            : 'sonata_type_model_list';

        return $formMapper->create('mediaId', $modelListType, array(
            'sonata_field_description' => $fieldDescription,
            'class' => $this->getMediaAdmin()->getClass(),
            'model_manager' => $this->getMediaAdmin()->getModelManager(),
            'label' => 'form.label_media',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {


        return $this->renderResponse($blockContext->getTemplate(), array(
            'media' => $blockContext->getSetting('mediaId'),
            'block' => $blockContext->getBlock(),
            'settings' => $blockContext->getSettings(),
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist(BlockInterface $block)
    {
        $block->setSetting('mediaId', is_object($block->getSetting('mediaId')) ? $block->getSetting('mediaId')->getId() : null);
    }

    /**
     * {@inheritdoc}
     */

    /**
     * {@inheritdoc}
     */
    public function preUpdate(BlockInterface $block)
    {
        $block->setSetting('mediaId', is_object($block->getSetting('mediaId')) ? $block->getSetting('mediaId')->getId() : null);
    }
}
