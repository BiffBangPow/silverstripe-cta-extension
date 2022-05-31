<?php

namespace BiffBangPow\Extension;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataExtension;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class CallToActionExtension extends DataExtension
{
    private static $db = [
        'LinkText'   => 'Varchar',
        'CTAType'    => 'Enum("None,Link,Download,External,Email", "None")',
        'LinkData'   => 'Varchar',
        'LinkAnchor' => 'Varchar',
    ];

    private static $has_one = [
        'DownloadFile' => File::class,
        'Action'       => SiteTree::class,
    ];
    private static $owns = [
        'DownloadFile',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(['CTAType', 'DownloadFile', 'LinkData', 'LinkText', 'ActionID', 'LinkAnchor']);
        $fields->addFieldsToTab('Root.Main', [
            DropdownField::create('CTAType', 'Call to action type',
                singleton($this->owner->ClassName)->dbObject('CTAType')->enumValues()),
            Wrapper::create(TreeDropdownField::create('ActionID', 'Link to page', SiteTree::class))
                ->displayIf("CTAType")->isEqualTo("Link")->end(),
            TextField::create('LinkAnchor')
                ->setDescription('Anchor to append to the end of the link (do not need to include #)')
                ->displayIf("CTAType")->isEqualTo("Link")->end(),
            UploadField::create('DownloadFile', 'Download File')->setFolderName('Downloads')
                ->displayIf('CTAType')->isEqualTo("Download")->end(),
            TextField::create('LinkData')
                ->setDescription('External link, email address, etc.')
                ->displayIf("CTAType")->isEqualTo("External")
                ->orIf("CTAType")->isEqualTo("Email")->end(),
            TextField::create('LinkText')->displayUnless("CTAType")->isEqualTo("None")->end(),
        ]);
        parent::updateCMSFields($fields);
    }

    public function getCTALink()
    {
        switch ($this->owner->CTAType) {
            case 'Email':
                $link = "mailto:" . $this->owner->LinkData;
                break;
            case 'External':
                $link = $this->owner->LinkData;
                break;
            case 'Link':
                $link = $this->owner->Action()->Link();
                if ($this->owner->LinkAnchor !== '' && $this->owner->LinkAnchor !== null) {
                    $link .= '#' . $this->owner->LinkAnchor;
                }
                break;
            case 'Download':
                $link = $this->owner->DownloadFile()->Link();
                break;
            default:
                $link = false;
        }

        return $link;
    }
}
