# Git Collaboration Rules

## Branches
- `main`: stable/demo-ready code only.
- `develop`: integration branch.
- Backend 1: `feature/backend-supply`
- Backend 2: `feature/backend-transaction`

## Ownership
Backend 1 owns Restaurant, Listing, Inventory, Partner controllers/requests, and Supply services.
Backend 2 owns User/Auth, Order, Payment, Pickup, Customer controllers/requests, and Transaction services.

## Shared files
Database contract must be agreed before coding. `routes/web.php`, package files, config, and shared auth setup require coordination.

## Rule
Use another developer's module; do not modify it directly unless agreed first. Prefer calling its service/model relationship over editing its owned file.
