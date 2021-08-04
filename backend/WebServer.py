# -*- coding: utf-8 -*-

import asyncio
from typing import Optional
from asyncio import AbstractEventLoop
from aiohttp.web import Application, AppRunner, TCPSite
from routes.Ping import PingRoutes
from routes.Target import TargetRoutes


class WebServer:

    loop: AbstractEventLoop
    core_app: Application
    app: Application
    runner: AppRunner
    site: TCPSite
    client_max_size: int = 10 * 1024 * 1024


    # Init
    async def init(self) -> None:
        self.core_app = Application(loop = self.loop,
            client_max_size = self.client_max_size
        )
        self.api = Application(loop = self.loop,
            client_max_size = self.client_max_size
        )

        # Add routes
        PingRoutes().add_routes( self.api.router )
        TargetRoutes().add_routes( self.api.router )

        # Add app
        self.core_app.add_subapp('/api/', self.api)


    # Create web server
    async def create_web_server(self) -> None:
        self.web_runner = AppRunner(self.core_app)
        await self.web_runner.setup()
        self.site = TCPSite(self.web_runner, '0.0.0.0', 8080)
        await self.site.start()

