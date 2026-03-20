---
title: "PawFed"
description: "A federated collaborative map for animal welfare"
icon: "pets"
logo: "/img/pawfed.svg"
badges: ["Web", "Next.js", "AGPL-3.0"]
weight: 5
platform: "Web (self-hosted)"
repo: "https://codeberg.org/tom79/PawFed"
website: "https://pawfed.org/"
---

PawFed is a collaborative federated map for animal welfare. The map starts empty and is populated by Fediverse users who mention the ActivityPub actor (`@pawfed@pawfed.org`) from their usual client (Mastodon, Misskey, etc.) with anything that can help an animal: shelters, food donations, foster families, reports, solidarity vets, water points, and more.

PawFed has its own ActivityPub actor (type Service) that federates content. Points on the map are published as AP Notes, can receive likes and boosts from the Fediverse, and the actor can be followed by other instances.

## How it works

1. A Fediverse user mentions `@pawfed@pawfed.org` with hashtags, a description, and optional photos
2. PawFed verifies the HTTP signature and checks rate limits and blocked words
3. An animal relevance filter scores the content (score >= 30 required)
4. The mention is parsed (species, category, photos, address) and geocoded
5. Trusted actors get their points published immediately, others go through moderation

## Categories

| Category | Examples |
|----------|----------|
| Places | Shelters, Vets, Dog Parks, Wildlife Centers |
| Services | Grooming, Training, Boarding, Pet Stores |
| Needs | Food, Supplies, Foster, Adoption, Sterilization |
| Reports | Lost Animal, Found Animal, Emergency, Water Points |

## Key features

- **No user login**: users interact via their existing Fediverse account by mentioning the actor
- **Mention-based reporting**: one report = one mention with hashtags, a description, and optional photos
- **Mandatory moderation**: nothing is published without validation (except trusted actors)
- **Progressive trust**: after N approved reports, an actor is auto-trusted
- **Community map**: all data comes from users
- **OSM fusion**: permanent places (shelters, vets) from OpenStreetMap are displayed via Overpass API with cache and multi-mirror fallback
- **Federated**: points are published as ActivityPub Notes to all followers
- **i18n**: English and French, community-translatable
- **Admin panel**: moderation queue, trust management, instance blocking, team invites, stats dashboard, 2FA