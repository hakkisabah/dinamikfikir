<?php
/**
 * View language strings.
 *
 * @package      CodeIgniter
 * @author       CodeIgniter Dev Team
 * @copyright    2014-2019 British Columbia Institute of Technology (https://bcit.ca/)
 * @license      https://opensource.org/licenses/MIT	MIT License
 * @link         https://codeigniter.com
 * @since        Version 3.0.0
 * @filesource
 *
 * @codeCoverageIgnore
 */
return [
    'users' => [
        'searchTitle' => 'Search user',
        'writeUserName' => 'Type username',
        'pageError' => "data cannot be retrieved, possibly a critical error exists. You may need to review the processing functions of the array ['admin_users_data']",
        'serverError' => 'The user cannot be updated due to a server problem.',
        'update' => 'Update',
        'reActivation' => 'User activation code has been successfully sent.',
        'reActivationElse' => 'The request to send a user activation code was applied, but a successful response was not received.',
        'reActivationErrorFromServer' => 'There appears to be a server side problem in sending activation.',
        'userUpdateSuccess' => 'User has been updated successfully',
        'detail' => [
            'title' => 'User detail',
            'suspendUser' => 'Suspend user',
            'sendActivationMail' => 'Send activation email',
            'sendCode' => 'Send code',
            'userId' => 'User id',
            'userName' => 'User name',
            'firstName' => 'User firstname',
            'lastName' => 'User lastname',
            'userMail' => 'User mail',
            'userLastLoginDate' => 'User last login date',
            'emailStatus' => 'User mail activation status',
            'setPassForUser' => 'Set user password',
            'setPassForUserPlaceHolder' => 'Enter password to set new password',
            'userCurrentIcon' => 'Users current icon',
            'userRole' => 'User authorization',
        ],
    ],
    'content' => [
        'script' => [
            'confirmContentDelete' => 'Content will be deleted, are you sure?',
            'contentDeleted' => 'Content deleted!',
        ],
        'detail' => [
            'detailHeader' => 'Content Detail',
            'contentDeleteLabel' => 'Delete content',
            'contentDeleteButton' => 'Delete',
            'viewContentLabel' => 'View content',
            'viewContentButton' => 'View',
            'displayProfileButton' => 'Visit profile',
            'contentTitleName' => 'Content title',
        ],
        'search' => [
            'searchHeader' => 'Search content',
            'searchBoxLabel' => 'Enter content name',
        ],
    ],
    'website' => [
        'update' => 'Update',
        'data_error' => "data cannot be retrieved, there is probably a critical error, you may need to review the processing functions of ['admin_site_data'] array",
        'ajax_mail_succes' => ' to successfully sent.',
        'ajax_mail_fail' => ' to could not send.',
        'awsTestButtonElementTextContextForWait' => 'Wait ..',
        'awsTestButtonElementTextContextForNormal' => 'Test and sync',
        'awsTestResultSuccess' => 'Test and sync successful!',
        'awsTestResultFail' => 'Test and synchronization failed. ',
        'show' => 'Show',
        'close' => 'Close',
    ],
    'general' => [
        'generalSettings' => 'General settings',
        'siteName' => 'Site name',
        'app_baseURL' => 'Site base URL',
        'awsWarning' => 'Attention, your server may behave unstable during location change,
                     You may experience problems due to overload. Please make a change of location considering your resource consumption. ',
        'awsWarningUp' => 'Content adding and updating process has been stopped, please make your choice within 10 seconds',
        'uploadLocation' => 'Upload location',
        'selectNameLocal' => 'Local',
        'selectNameAWS' => 'AWS',
    ],
    'enabledChecker' => [
        'logSettings' => 'Log settings',
        'file' => 'FILE',
        'sql' => 'SQL',
        'mailSettings' => 'Mail settings',
        'system' => 'SYSTEM',
        'awsSettings' => 'Aws settings',
    ],
    'mailConf' => [
        'mailSystem' => 'Mail system',
        'show' => 'Show',
        'mailProvider' => 'Mail provider',
        'mailProviderPlaceHolder' => 'Ex: mail.youraddress.com',
        'mailUser' => 'Mail user',
        'mailUserPlaceHolder' => 'Ex: hakisabah@youraddress.com',
        'userPass' => 'User password',
        'userPassPlaceHolder' => 'Enter your mail password',
        'mailPort' => 'Mail port',
        'mailPortPlaceHolder' => 'Example: 587',
        'testMailLabel' => 'Enter the test address you will send mail to',
        'testMailPlaceHolder' => 'For example; hakisabah@hotmail.com',
        'testMailTestButton' => 'Test',
        'protocol' => 'Protocol',
        'protocolPlaceHolder' => 'Example: SMTP',
        'senderPath' => 'Sender path',
        'charSet' => 'Character set',
        'charSetPlaceHolder' => 'Example: utf8',
        'wordWrap' => 'WordWrap',
        'wordWrapOn' => 'Open',
        'wordWrapOff' => 'Off',
        'priority' => 'Mail priority',
        'activationSegment' => 'Activation segment',
        'activationSegmentPlaceHolder' => 'Example: users/activation/',
        'activationMailAddress' => 'Activation email address',
        'mailName' => 'Mail name',
        'subject' => 'Subject title',
    ],
    'awsConf' => [
        'awsSystem' => 'AWS system',
        'show' => 'Show',
        'serverRegion' => 'Server region',
        'serverRegionPlaceHolder' => 'Example: eu-central-1',
        'accessKey' => 'Access key',
        'accessKeyPlaceHolder' => 'Ex: AKIAJSGDUGDOWEJU6SM4A',
        'secretKey' => 'Secret key',
        'secretKeyPlaceHolder' => 'Ex: ZGRvKxuZ2BMsKiuYMr/ZoK0eKkisAn5T8qcYaQqSX',
        'bucketName' => 'Bucket name',
        'bucketNamePlaceHolder' => 'Example: dinamikfikir.com',
        'publicAddress' => 'Full access address',
        'publicAddressPlaceHolder' => 'Example: https://cdn.dinamikfikir.com',
    ],
    'captchaConf' => [
        'show' => 'Show',
        'captchaSystem' => 'Captcha system',
        'secretKey' => 'Secret key',
        'secretKeyPlaceHolder' => 'Example: 6LdJWa0FAAAAAJlxXj2ySSd4r7w_5oI39eAGsd9D',
        'siteKey' => 'Site key',
        'siteKeyPlaceHolder' => 'Example: 6LdJDa0YAAAAAOOidYz-0f1hdMC6kOt_GfZuMMz0',
    ],
    'imageLocationConf' => [
        'imageLocation' => 'Image location',
        'show' => 'Show',
        'imageMainPath' => 'Image main path',
        'realImagePath' => 'Real Image path',
        'tempImagePath' => 'Temporary image path',
        'iconImagePath' => 'Icon image path',
    ],
    'report' => [
        'site_user' => [
            'title' => 'Registered user reports',
            'userName' => 'User name',
            'lastLogin' => 'Last login',
            'totalContent' => 'Total content',
            'totalComment' => 'Total comments',
            'regDate' => 'Registration date',
            'userRole' => 'User role',
        ],
        'guest_user' => [
            'title' => 'General user reports',
            'id' => 'Id',
            'ipInfo' => 'Ip info',
            'userName' => 'Username',
            'lastSeenLocation' => 'Last seen',
            'lastSeenTime' => 'Last seen time',
            'cookieDismiss' => 'Cookie consent',
        ],
        'admin_footer' => [
            'sEmptyTable' => 'No data available in table.',
            'sInfo' => 'Showing _START_ to _END_ of _TOTAL_ entries',
            'sInfoEmpty' => 'No record',
            'sInfoFiltered' => '(filtered from _MAX_ total entries)',
            'sLengthMenu' => 'Show _MENU_ entries',
            'sLoadingRecords' => 'Loading ...',
            'sProcessing' => 'Processing ...',
            'sSearch' => 'Search:',
            'sZeroRecords' => 'No matching records found',
            'sFirst' => 'First',
            'sLast' => 'End',
            'sNext' => 'Next',
            'sPrevious' => 'Previous',
            'sSortAscending' => ': activate to sort column ascending',
            'sSortDescending' => ': activate to sort column descending',
            '_' => '% d records selected',
            '1' => '1 record selected',
        ],
    ],
];