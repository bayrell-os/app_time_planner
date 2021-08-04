# -*- coding: utf-8 -*-

from aiohttp.web import Response, Request, UrlDispatcher
from routes.Api import ApiRoutes

class TargetRoutes(ApiRoutes):

    prefix_url: str = "/target/"
    prefix_name: str = "api:target"

