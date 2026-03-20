---
title: "UntrackMe"
description: "Transform tracking URLs into privacy-friendly alternatives"
icon: "link_off"
logo: "/img/untrackme.svg"
badges: ["Android", "Java", "GPL v3"]
weight: 6
platform: "Android"
repo: "https://framagit.org/tom79/nitterizeme"
fdroid: "https://f-droid.org/packages/app.fedilab.nitterizeme/"
---

UntrackMe intercepts links on your Android device and redirects them to privacy-friendly front-ends. It also strips tracking parameters from any URL, giving you cleaner, tracker-free browsing. It works system-wide and transparently, no manual copy-paste needed.

## Supported redirections

| Platform | Redirects to |
|----------|-------------|
| Twitter / X | Nitter |
| YouTube | Invidious |
| Instagram | Bibliogram |
| Reddit | Teddit |
| Medium | Scribe |
| Wikipedia | Wikiless |
| TikTok | ProxiTok |
| Google Maps | OpenStreetMap |

## Key features

- **URL cleaning**: removes tracking parameters (UTM, Google Analytics, Facebook, and more) via dynamic rules
- **Short URL unrolling**: follows redirections from t.co, bit.ly, and 21 other shortener services
- **AMP removal**: strips Google AMP redirections to show the original page
- **Outlook SafeLinks**: unwraps Microsoft SafeLinks URLs
- **Custom instances**: choose your preferred front-end instances for each platform
- **Latency checker**: test instance response times and see Cloudflare usage
- **App delegation**: redirect to capable apps installed on your device instead of the browser
- **Invidious settings**: customize 14+ player parameters (dark mode, quality, subtitles, autoplay, and more)
- **Lite version**: minimal version available without the built-in app picker
