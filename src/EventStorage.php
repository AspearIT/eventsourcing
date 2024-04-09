<?php

namespace Veldsink\EventSourcing;

use Symfony\Component\Uid\Uuid;

class EventStorage
{
    public function getEvents(Uuid $domainUuid): array
    {
        $data = $this->getEventData($domainUuid);
        if (count($data) === 0) {
            throw new \RuntimeException('No events found for domain ' . $domainUuid);
        }
        return array_map(function (array $event): Event {
            $type = $event['type'];
            return $type::fromPayload(
                Uuid::fromString($event['domainUuid']),
                $event['version'],
                $event['payload'],
            );
        }, $data);
    }

    public function saveEvent(Event $event): void
    {
        $data = $this->getEventData($event->domainUuid);
        $data[] = [
            'type' => get_class($event),
            'version' => $event->version,
            'domainUuid' => $event->domainUuid,
            'payload' => $event->payload,
        ];
        file_put_contents($this->getPath($event->domainUuid), json_encode($data));
    }

    private function getEventData(Uuid $domainUuid): array
    {
        if (!is_file($this->getPath($domainUuid))) {
            return [];
        }
        return json_decode(file_get_contents($this->getPath($domainUuid)), true);
    }

    private function getPath(Uuid $uuid): string
    {
        return __DIR__ . '/../data/' . $uuid->toRfc4122() . '.json';
    }
}