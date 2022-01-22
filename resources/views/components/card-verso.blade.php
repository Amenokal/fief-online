<span @class([
    "card",
    "lord-card" => $type === 'lord',
    "event-card" => $type === 'event' && !$disaster,
    "disaster-card" => $type === 'event' && $disaster
])></span>