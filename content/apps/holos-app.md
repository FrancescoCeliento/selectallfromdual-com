---
title: "Holos App"
description: "Your phone is your Fediverse server, a fully decentralized mobile platform"
icon: "smartphone"
logo: "/img/holos-app.svg"
badges: ["Android", "React Native", "AGPL-3.0"]
weight: 2
platform: "Android"
repo: "https://codeberg.org/tom79/Holos-App"
website: "https://holos.social/signup"
---

Holos App is a mobile Fediverse platform where **your phone IS your ActivityPub server**. Unlike traditional clients, Holos runs a complete decentralized server directly on your device. You own your keys, your data, and your identity.

## How it works

Holos embeds a Node.js server on the device that speaks native ActivityPub. A [relay server](/apps/holos-relay/) provides a stable identity (`@you@relay.domain`) and proxies requests to your phone, even when your IP changes. When you're offline, activities are queued and delivered when you reconnect.

## Key features

- **True decentralization**: no central server, your phone is the instance
- **Multi-account**: isolated accounts with separate cryptographic keys
- **Full social experience**: posts, media, polls, content warnings, quote posts
- **Multiple timelines**: Home, Local, Public, Hashtag, Discover
- **Direct messaging**: private conversations with threads
- **End-to-end encryption**: encrypted DMs using the Signal Protocol with safety number verification
- **Video feed**: vertical video feed and PeerTube video discovery
- **Offline support**: actions queued and synced on reconnect with Bloom filter optimization
- **Post TTL**: auto-delete posts after a set duration
- **Discovery**: find content and people across the Fediverse via [Holos Discover](/apps/holos-discover/)
- **Custom domains**: use your own domain as your Fediverse identity
- **Backup/Restore**: cloud (S3/WebDAV) or local database backups
- **Content filters**: keyword-based filtering with per-context rules
- **Lists and followed tags**: organize your feeds
- **Custom emoji**: full support for instance custom emoji
- **Moderation**: block instances, users, and import external blocklists
- **IP privacy**: all outgoing requests proxied through the relay to hide your mobile IP
- **Translations**: English and French maintained, others via Weblate

## Part of the Holos ecosystem

- **Holos App**: the mobile client with embedded ActivityPub server (this project)
- [Holos Relay Server](/apps/holos-relay/): provides stable identity and message proxying for mobile instances
- [Holos Discover](/apps/holos-discover/): a consent-based Fediverse search engine (optional, independent)
