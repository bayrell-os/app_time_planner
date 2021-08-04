#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import asyncio
from asyncio import AbstractEventLoop
from WebServer import WebServer


async def start(loop: AbstractEventLoop) -> None:

    web_server = WebServer()
    web_server.loop = loop

    # Init server
    await asyncio.wait([
        loop.create_task( web_server.init() ),
    ])

    # Start server
    await asyncio.wait([
        loop.create_task( web_server.create_web_server() ),
    ])

    # Loop
    while True:
        await asyncio.sleep(1)

    # Close connection
    await web_server.web_runner.cleanup()


if __name__ == "__main__":
    loop = asyncio.get_event_loop()
    loop.run_until_complete( start(loop) )
    loop.close()
