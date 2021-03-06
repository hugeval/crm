<?php

namespace OroCRM\Bundle\ChannelBundle\Entity\Manager;

use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;

class ChannelApiEntityManager extends ApiEntityManager
{
    /**
     * {@inheritdoc}
     */
    protected function getSerializationConfig()
    {
        $config = [
            'fields' => [
                'dataSource' => ['fields' => 'id'],
                'entities'   => ['fields' => 'name'],
                'status'     => [
                    'result_name' => 'active'
                ],
            ]
        ];

        return $config;
    }
}
