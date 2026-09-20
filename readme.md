# FoodSafe 

**FoodSafe** is a modern, containerized web application designed to help manage and distribute surplus food. Built with a robust Laravel backend and a reactive Vite-compiled frontend, the application is deployed on a highly secure, bare-metal production environment utilizing modern DevOps practices, Zero Trust networking, and automated CI/CD pipelines.

---

## Technical Stack

* **Backend & API:** Laravel 11, PHP 8.4
* **Frontend:** HTML/CSS/JS compiled via Vite & Node.js
* **Database:** MySQL 8.0 (Production), SQLite (Testing)
* **Infrastructure:** Bare-Metal Debian 13, Docker, Docker Compose
* **CI/CD:** GitHub Actions (Self-Hosted Runner)
* **Networking & Security:** Cloudflare Tunnels (Zero Trust Ingress)

---

## DevOps & Infrastructure Architecture

This repository is built with a production-first mindset, emphasizing infrastructure as code (IaC), credential security, and developer parity.

### 1. Standardized Development Environments (DevContainers)

To eliminate the "it works on my machine" problem across the frontend and backend engineering teams, the local development workflow is strictly containerized.

* Developers spin up identical environments using VS Code DevContainers.
* The local `docker-compose.yml` automatically mounts the codebase, provisions a local MySQL database, and exposes necessary ports (8000 for PHP, 5173 for Vite) without requiring manual package installations on the host machine.

### 2. Bare-Metal CI/CD Pipeline

Deployment is fully automated via GitHub Actions, communicating securely with a self-hosted runner residing on a private bare-metal Debian server.

* **Automated Rollouts:** Merging to the `main` branch triggers the deployment workflow.
* **Runner Security:** The repository enforces strict environment protection rules, ensuring that workflows cannot be hijacked by malicious pull requests or unauthorized branch commits.
* **Zero Downtime Orchestration:** The runner executes a repository-level `docker-compose-prod.yml` which seamlessly rebuilds the application image and swaps out the active container while leaving the persistent MySQL database container untouched.

### 3. Isolated Secrets Management

Production credentials, database passwords, and Laravel application keys are **never** committed to version control or stored in cloud-hosted secrets managers.

* Secrets are maintained strictly on the bare-metal host in a protected configuration directory (`$HOME/surplus-deploy/.env`).
* During deployment, Docker Compose dynamically injects these secure variables into the production application container at runtime via secure volume mounts, maintaining a strict air-gap between the source code and production keys.

### 4. Zero Trust Ingress (Cloudflare Tunnels)

The application is exposed to the public internet (`FoodSafe.ambadrive.cfd`) without opening any inbound ports on the host router or firewall.

* A standalone `cloudflared` Docker container runs perpetually on the Debian server.
* It establishes a secure, outbound-only tunnel to Cloudflare's edge network.
* Cloudflare handles all SSL/TLS termination, DDoS protection, and DNS routing, forwarding legitimate HTTP traffic directly into the isolated Docker bridge network.

---

