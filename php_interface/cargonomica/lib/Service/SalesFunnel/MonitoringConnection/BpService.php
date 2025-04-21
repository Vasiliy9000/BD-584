<?php

namespace Cargonomica\Service\SalesFunnel\MonitoringConnection;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\UserGroupTable;
use Cargonomica\Service\SalesFunnel\SalesFunnelServiceBase;

/**
 * Класс предназначен для минимизации кода, который используется в шаблонах БП.
 * Класс предполагает описание всей исполняемой логики здесь, а в шаблонах БП лишь использование этих методов.
 * Класс работает с воронкой "Подключение к мониторингу".
 */
class BpService extends SalesFunnelServiceBase
{
    /**
     * Руководитель отдела продаж
     */
    protected const TASK_MANAGER_GROUP = MONITORING_CONNECTION_HEAD_OF_SALES_DEPARTAMENT_UG_ID;

    /**
     * Возвращает идентификатор пользователя -технического специалиста (одиночное значение).
     *
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getTechnicalSpecialist(): array
    {
        $usersGroupsDbResult = UserGroupTable::getList([
            'select' => ['USER_ID',],
            'filter' => ['GROUP_ID' => MONITORING_CONNECTION_TECHNICAL_SPECIALIST_UG_ID,],
            'group' => 'USER_ID',
            'cache' => ['ttl' => 3600 * 24 * 30],
        ]);
        while ($row = $usersGroupsDbResult->fetch()) {
            $userIds[] = (int)$row['USER_ID'];
        }
        return $userIds ?? [];
    }
}
