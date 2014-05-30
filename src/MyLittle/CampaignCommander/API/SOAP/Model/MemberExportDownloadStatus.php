<?php

namespace MyLittle\CampaignCommander\Client\Model;

/**
 * Campaign Commander MemberExport Download status
 *
 * Campaign Commander Member Export API uses MemberExport Download Files objects.
 * Here is the list of allowed statuses.
 *
 * @author Mathieu Ferment <mathieu.ferment@mylittleparis.com>
 */
final class MemberExportDownloadStatus
{
    const STATUS_SUCCESS = 'OK';
    const STATUS_EMPTY = 'NO_DATA';
    const STATUS_NOT_READY = 'NOT_YET_READY';
    const STATUS_ERROR = 'ERROR';

    static public function getMemberExportDownloadStatusList()
    {
        $result = [
            self::STATUS_EMPTY,
            self::STATUS_NOT_READY,
            self::STATUS_SUCCESS,
            self::STATUS_ERROR
        ];

        return $result;
    }
}
