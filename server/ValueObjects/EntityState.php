<?php

namespace Cursotopia\ValueObjects;

enum EntityState : string {
    case CREATE = "CREATE";
    case UPDATE = "UPDATE";
}
