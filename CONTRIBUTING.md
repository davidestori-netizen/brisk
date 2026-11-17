# Contributing to Brisk

Thank you for helping with Brisk. These are the few rules for a contribution
(a pull request, a patch) to be accepted.

## License

Brisk is free software, released under the GNU Affero General Public
License, version 3 or (at your option) any later version: see `COPYING`.
Brisk is a service used over the network: whoever runs a modified version
of it for others has to offer them its source code (section 13 of the
license). By contributing you release your contribution under the same
license. You keep the copyright on what you wrote: add your name to
`AUTHORS`, and to the copyright line of the files you create or
substantially change, for example:

    Copyright (C) 2006-2026 Matteo Nastasi and contributors (see AUTHORS)

## Developer Certificate of Origin (DCO)

Every commit must be signed off: its message ends with a line

    Signed-off-by: Your Name <your.email@example.org>

with your real name and an email address you can be reached at. With it
you certify what is written in `DCO` (the Developer Certificate of Origin
1.1): in short, that you wrote the contribution, or have the right to
submit it under the license of the project, and that you know it and your
sign-off stay public in the history of the project.

Git adds the line for you:

    git commit -s

If you forgot it:

    git commit --amend -s --no-edit       # the last commit
    git rebase --signoff master           # all the commits of your branch

and then push the branch again (`git push --force-with-lease`).

Pull requests with commits that are not signed off are not merged.

## Commits

- Code, comments, documentation and commit messages are in English.
- One topic per commit, with a message that says what changes and why.
- Keep the style of the file you are changing.
