<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/monitoring.proto

namespace GPBMetadata\Google\Api;

class Monitoring
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
google/api/monitoring.proto
google.api"�

MonitoringK
producer_destinations (2,.google.api.Monitoring.MonitoringDestinationK
consumer_destinations (2,.google.api.Monitoring.MonitoringDestinationD
MonitoringDestination
monitored_resource (	
metrics (	Bq
com.google.apiBMonitoringProtoPZEgoogle.golang.org/genproto/googleapis/api/serviceconfig;serviceconfig�GAPIbproto3'
        , true);

        static::$is_initialized = true;
    }
}

