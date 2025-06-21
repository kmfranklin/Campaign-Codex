# Campaign Codex

**Campaign Codex** is a reference and content management application for tabletop RPGs. It's designed to provide players and Dungeon Masters with a clean, searchable, and extensible interface for browsing rules, spells, creatures, items, and more — sourced from open-content systems like the 5e SRD and Level Up: Advanced 5e (A5E).

While the current phase focuses on building the backend and importing normalized data from the 5.1 SRD (via Open5e), future phases will include:

-   A public-facing frontend for browsing all rules and entities
-   User accounts for creating and managing custom content
-   Tools for building characters, loot tables, and encounters
-   System-agnostic content tagging and filtering
-   Cross-referencing between rules (e.g., "Spell X uses ability Y")

## Data Import Workflow

The SRD data is imported using a custom Artisan-based pipeline:

1.  **Monolithic JSON source file** placed in `/storage/json/`
2.  **Split commands** convert that file into individual record JSONs:

```
  bash
  php artisan open5e:split-<model> # e.g., open5e:split-spells
```

3.  **Seeders** read from `/storage/data/srd-2014/` and populate the relational database.

All migrations, models, seeders, and split commands are committed and reusable.

## Cleanup

Split JSON files are not versioned to keep the repository lean. You can regenerate them at any time using the split commands. To clean up:

        Remove-Item -Path "storage\data\srd-2014" -Recurse -Force

## Getting Started

Clone and set up Laravel as usual:

```
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate --seed
```

## Development Roadmap

### Phase 0: Project Scaffolding (Complete)

-   Laravel 11 installed
-   Installed Laravel Breeze with Blade templates
-   Jetstream (Inertia + Vue 3) setup
-   TailwindCSS via Vite
-   PostgreSQL configured
-   Built user dashboard at `/dashboard`
-   .gitignore and README initialized

### Phase 1: Campaign Management Core (Complete)

-   Global user role support (`admin`, `user`)
-   Built `Campaign` model and migration (with `owner_id`, `slug`, etc.)
-   Created `campaign_user` pivot table with role-based access (`dm`, `player`)
-   Implemented campaign creation form (creator auto-joins as DM)
-   Displays all joined campaigns on dashboard with role and DM shown
-   Created slug-based campaign join flow:
    -   Lookup via slug
    -   Session-based confirmation page
    -   Final join submission
-   Prevent duplicate campaign joins
-   Shows campaign slug to DMs on dashboard
-   Added Blade views for create, join, and confirm join steps

### Phase 2: Data Import Infrastructure (Complete)

-   Create `documents` table to track content sources
-   Designed normalized schema for all SRD data types (spells, items, creatures, etc.)
-   Created custom `open5e:split-<model>` Artisan commands to split monolithic JSON
-   Created matching seeders to populate database
-   Verified that all 5.1 SRD data was imported successfully and mapped to the correct models
-   Removed split JSON files from storage to reduce repo size
-   Updated README to document import process and cleanup steps

### Phase 3: Public Reference Frontend

-   Route structure for public views (`/spells`, `/items`, `/classes/{slug}`, etc.)
-   Blade/Inertia pages for browsing each model with filters and search
-   System-specific filtering (`SRD` vs `A5E`)
-   Responsive design for mobile usability
-   Pagination and SEO-friendly URLs

### Phase 4: Custom Content System

-   Registered users can create/edit homebrew spells, items, etc.
-   Custom content tied to individual accounts
-   "Save as" feature for duplicating and editing official SRD entries
-   Campaign-specific content tagging or grouping

### Phase 5: Campaign Logs and Notes System

-   DM and players can contribute to a shared campaign log (session recaps, adventure summaries, etc.)
-   DMs can create private campaign notes (world lore, secrets, planning, etc.)
-   Players can add personal notes visible only to themselves
-   All notes are tied to specific campaigns and scoped by role
-   Markdown support, tag filters, and optional visibility toggles

### Phase 6: Tools and Utilities

-   Loot table builder (randomized, filterable)
-   Encounter generator based on CR, biome, party level, etc.
-   Character builder (stretch goal)
-   PDF/JSON export tools
-   Dice roller, initiative tracker, and other play support tools

### Phase 7: A5E Integration

-   Repeat import process for Level Up: Advanced 5e JSON data
-   Adjust schema as needed to handle A5E-specific fields
-   Add filtering, toggles, or system tabs to view A5E vs SRD content

## Stretch Goals and Generative Tools

### NPC Generator

-   Randomized or semi-randomized generation of NPCs with:
    -   Name, race/species, role (merchant, blacksmith, etc.)
    -   Personality traits, bonds, flaws (from SRD or custom pools)
    -   Motivations, secrets, voice, and/or quirks
    -   Option to save to campaign notes or public NPC list

### Tavern / Town Generator

-   Generate settlements with:
    -   Names, size, population, government
    -   Map-style layout or listing of establishments (taverns, blacksmiths, etc.)
    -   Key NPCs auto-linked
    -   Local rumors or plot hooks

### Worldbuilding Wiki

-   In-app wiki-style tool for world creation
    -   Categories: regions, deities, factions, languages, historical events
    -   Link entries to campaigns, notes, or items
    -   Markdown editing + tagging
    -   Timeline view or map integration (eventual)

### Region + Dungeon Map Generator (Advanced)

-   Visual map generators or tile-placement tools
-   Random dungeon layout generation with export options
-   Link rooms to content (monsters, traps, loot, etc.)

### Plot Hook + Encounter Generator

-   "Roll-a-hook" tool to generate quest starters or complications
-   Themed by biome, faction, level range
-   Include flavor text, objective, possible NPC/creature involvement

### Name Generators

-   Fantasy name banks by culture, race/species, or region
-   Options for:
    -   People (first + last)
    -   Locations
    -   Magic items
    -   Taverns, inns, shops

## License

Campaign Codex uses open-source content sourced from [Open5e](https://open5e.com/) and is compliant with the terms of the [Open Gaming License (OGL)](https://open5e.com/legal). Custom code is [MIT-licensed](https://opensource.org/licenses/MIT).
