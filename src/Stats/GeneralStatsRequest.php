<?php
namespace Kirugan\Advertstar\Stats;

use Kirugan\Advertstar\AbstractRequest;

class GeneralStatsRequest extends AbstractRequest
{
    public function __construct($beginDate, $endDate, array $fields, array $groups)
    {
        $this->data['begin_date'] = $beginDate;
        $this->data['end_date'] = $endDate;
        $this->data['fields'] = $fields;
        $this->data['groups'] = $groups;
    }

    public function getName()
    {
        return 'stats/general_stats';
    }

    public function setOffers(array $offers)
    {
        $this->data['admedia_id'] = array_filter(array_map('intval', $offers));
    }
}