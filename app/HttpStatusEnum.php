<?php

namespace App;

enum HttpStatusEnum
{
    case OK;
    case INTERNAL_SERVER_ERROR;
    case CREATED;
    case NOT_FOUND;
    case BAD_REQUEST;
}
