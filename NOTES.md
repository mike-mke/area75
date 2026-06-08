## Me

Help me create a modern webapp using the languages/frameworks listed below that has all the functionality available in https://area75.org/page/home.
Make sure to explore all subpages but nothing outside of that domain (area75.org).

These are the Development tools I want to use:
/opt/homebrew/bin/php
/opt/homebrew/bin/symfony
PostgreSQL running locally on port 5432

The project working directory already has an index.html file - rename it so that it's preserved. feel free to take ideas from it but not the color scheme.


## Claude

The Symfony app is ready in your area75/ folder. To get it running, open a terminal in that directory and run these three commands:

* bashcomposer install
* php bin/console doctrine:database:create
* php bin/console doctrine:migrations:migrate
* symfony server:start

Then open http://localhost:8000.

What was built:
The app faithfully mirrors all functionality from area75.org with a warm, earthy redesign (cream/terracotta/sage green palette, Lora serif + Nunito sans):

* Home — featured assembly cards, upcoming events feed, site purpose, announcements
* Events calendar — monthly view with prev/next navigation, upcoming events sidebar, individual event detail pages
* Event submission — login-gated form with PDF flyer upload, terms agreement; submitted events await admin approval
* User auth — register, login, logout, remember me, forgot password / token-based reset

* All 7 About pages — What is AA, Preamble, 12 Steps, 12 Traditions, AA Resources (all 5 central offices), Message to Teens, Structure of AA
* All 10 Area Business pages — Business Meetings (with all PDF form links), District Meetings (full table of all 32 districts), Registrar, plus all 9 committee pages (Accessibilities, Archives, Corrections, CPC, Finance, Grapevine, Literature, Public Information, Treatment, Technology)
* Postgres schema — user and event tables via a ready-to-run Doctrine migration
* The original index.html is preserved as index_original.html

See SETUP.md for the full setup guide including how to promote a user to admin.

## Notes
* After running all the preliminary setup steps, you actually want to navigate to this URL: http://localhost:8001

## To Do
* Allow an admin to accept/reject an Event
* Al to put in the current schema actually used and have Claude use it (or send the schema to Mike)

## Additional Features
#### Group Management
* Allow ordinary users to add/edit a Group (once accepted, they lose the right to edit it)
* Allow admin users to accept/reject Groups
* Allow admin users to add/edit Groups
* Allow admin users to retire/delete Groups (Should all users see 'retired' Groups or just admins?)

#### Assembly Cards Management
* Allow admin users to add/edit/delete the upcoming Assembly Cards (site should show the next three)

