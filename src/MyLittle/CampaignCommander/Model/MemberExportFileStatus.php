<?php

namespace MyLittle\CampaignCommander\Client\Model;

/**
 * Campaign Commander MemberExport File status
 *
 * Campaign Commander Member Export API uses MemberExport Files objects.
 * Here is the list of allowed statuses.
 *
 * @author Mathieu Ferment <mathieu.ferment@mylittleparis.com>
 */
final class MemberExportFileStatus
{
    const STATUS_VALIDATED = 'VALIDATED';
    const STATUS_RUNNING = 'RUNNING';
    const STATUS_SUCCESS = 'SUCCESS';
    const STATUS_ERROR = 'ERROR';
    const STATUS_DELETED = 'DELETED';

    static public function getExportFileStatusList()
    {
        $result = [
            self::STATUS_VALIDATED,
            self::STATUS_RUNNING,
            self::STATUS_SUCCESS,
            self::STATUS_ERROR,
            self::STATUS_DELETED

        ];

        return $result;
    }
}
