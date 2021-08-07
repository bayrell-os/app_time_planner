# -*- coding: utf-8 -*-

from aiohttp.web import Response, Request, UrlDispatcher


class ApiRoutes:

    prefix_url: str = "/test/"
    prefix_name: str = "api:test"

    
    # Add routes
    def add_routes(self, router: UrlDispatcher) -> None:

        router.add_route("GET", self.prefix_url, self.index, name=self.prefix_name + ":index")
        router.add_route("POST", self.prefix_url, self.index, name=self.prefix_name + ":index")
        

    # Index
    async def index(self, request: Request) -> Response:
        return Response(text="{}")

    