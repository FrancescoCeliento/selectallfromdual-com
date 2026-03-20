---
title: "Holos Discover"
description: "A privacy-first, consent-based search engine for the Fediverse"
icon: "travel_explore"
logo: "/img/holos-discover.svg"
badges: ["Server", "Node.js", "AGPL-3.0"]
weight: 4
platform: "Self-hosted"
repo: "https://codeberg.org/tom79/Holos-Discover"
website: "https://discover.holos.social/"
---

Holos Discover is a search engine for the Fediverse that only indexes content from users who have explicitly opted in. It works as a native ActivityPub participant, not a web crawler. Users keep full control over their data and can opt out at any time.

## How it works

1. An admin seeds initial users via CLI or subscribes to ActivityPub relays
2. Holos Discover sends Follow requests to users who meet the consent criteria
3. When accepted, their public posts are indexed for full-text search
4. New users are discovered organically from mentions, boosts, and replies
5. The network grows naturally while always respecting user privacy

## Consent model

A user is only indexed if **all** of these are true:

- `indexable = true` in their profile
- Account is not locked
- No `#nobot` or `#noindex` in bio
- User has not blocked the Discover instance

Users can also interact directly: mention the bot with "follow" or "unfollow". Blocking the instance immediately removes all indexed content.

## Key features

- **Full-text search**: search across all indexed posts with filters by language, content type, and sort order
- **Trending hashtags**: popular tags with velocity-based scoring and time decay
- **Trending posts**: most engaged posts with author diversity limits
- **Trending links**: popular shared URLs with anti-spam filtering
- **Safe search**: sensitive content filtered by default, with show/hide/only options
- **Multi-tag timeline**: filter by multiple hashtags with cursor pagination
- **ActivityPub relays**: connect to Fediverse relays for faster user discovery
- **Public stats page**: real-time dashboard with indexed posts, users, instances, and activity charts
- **Moderation tools**: block instances, users, domains, hashtags, and banned words via CLI
- **Suspension detection**: automatically detect and handle instances that have blocked the service
- **API with rate limiting**: REST API with key-based access for higher limits

## Independent project

Holos Discover works as a standalone Fediverse search engine. It can also power the discovery features in [Holos App](/apps/holos-app/), but it does not depend on any other Holos component.

- [Holos App](/apps/holos-app/): the mobile client with embedded ActivityPub server
- [Holos Relay Server](/apps/holos-relay/): stable identity and message proxying
