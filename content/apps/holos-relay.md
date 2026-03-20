---
title: "Holos Relay Server"
description: "Stable identity and message relay for mobile Fediverse instances"
icon: "hub"
logo: "/img/holos-light.svg"
badges: ["Server", "Node.js", "AGPL-3.0"]
weight: 3
platform: "Self-hosted"
repo: "https://codeberg.org/tom79/Holos-Relay-Server"
website: "https://holos.social/"
---

The Holos Relay Server solves a fundamental problem: mobile devices cannot have stable URLs. The relay provides permanent identities like `@alice@relay.domain` and proxies ActivityPub requests to the user's phone, wherever it is.

## How it works

When a Fediverse server wants to reach a Holos user, it contacts the relay at their stable address. The relay forwards the request to the phone through a WebSocket tunnel. When the phone is offline, activities are queued and delivered on reconnect.

## Key features

- **Stable identities**: `@user@relay-domain` format that never changes
- **WebFinger support**: standard actor discovery via `/.well-known/webfinger`
- **WebSocket tunnel**: HTTP-over-WebSocket to reach mobile devices behind NAT
- **Activity queue**: stores activities when mobile is offline, with Bloom filter sync for efficient catch-up
- **Profile caching**: avatars, headers, bios cached for 24/7 visibility
- **Activity proxy**: relays outgoing requests to hide the user's mobile IP
- **Push notifications**: UnifiedPush and Expo integration
- **Custom domains**: support for `@user@custom.domain` with DNS verification
- **OAuth 2.0**: secure authentication with PKCE support and JWT tokens
- **Custom emoji**: per-instance emoji management with proxy and caching
- **Admin panel**: user moderation, team management, reports
- **2FA**: TOTP two-factor authentication
- **Outbound rate limiting**: per-domain adaptive rate limiting for federation
- **Prometheus metrics**: full monitoring support
- **Caddy reverse proxy**: automatic HTTPS with Let's Encrypt

## Part of the Holos ecosystem

- [Holos App](/apps/holos-app/): the mobile client with embedded ActivityPub server
- **Holos Relay Server**: stable identity and message proxying (this project)
- [Holos Discover](/apps/holos-discover/): a consent-based Fediverse search engine (optional, independent)
