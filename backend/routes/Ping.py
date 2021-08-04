# -*- coding: utf-8 -*-

from aiohttp.web import Response, Request, UrlDispatcher


class PingRoutes:

    def add_routes(self, router: UrlDispatcher) -> None:
        router.add_route("GET", "/", self.index, name='api:ping:index')
        pass


    async def index(self, request: Request) -> Response:
        return Response(text="Hello world !!!")
        