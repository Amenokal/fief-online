<span @class([
    "card",
    "lord-card" => $type === 'lord' && !$disaster,
    "event-card" => $type === 'event' && !$disaster,
    "disaster-card" => $type === 'event' && $disaster
])>

</span>