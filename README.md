# Voltage

**Voltage** is a modern, real-time chat application built using the TALL stack (Tailwind CSS, Alpine.js, Laravel, and Livewire). It offers fully customizable profiles, private and group chat capabilities, and a dynamic interface that keeps users updated with the latest changes.

## 🚀 Features

### 🧑‍🎤 Profiles and Customization
- **Profile & Banner Images:** Upload custom profile and banner images.
- **Personal Information:** Set and update your name, username, pronouns, and bio.
- **Themes:** Choose between light and dark UI modes.

### 💬 Chat Functionality
- **Private Chats:** One-on-one messaging with other users.
- **Group Chats:** Create and manage group chats with ease.
  - **Add/Remove Users:** Dynamically add or remove participants from group chats.
  - **Group Management:** Rename group chats.
- **Read Status Tracking:** Keep track of any new messages so you are always in the loop.

### 🌐 Real-Time Updates
- **Live Messaging:** Instant updates on new messages without refreshing the page.
- **Status Updates:** Dynamically show any changes to group chats, such as renames or members joining or leaving.

## 🛠️ Installation
To run Voltage locally using Laravel Sail, follow these steps:

### Prerequisites
- **Docker:** Ensure Docker is installed and running on your machine.

### Steps
1. **Clone the Repository**
2. **Set up Environment Variables** (You will need Pusher API Credentials)
3. **Install Composer Dependencies:** ```composer install```
4. **Start Docker Containers:** ```./vendor/bin/sail up``` (Ensure Docker is Running)
5. **Generate Application Key:** ```./vendor/bin/sail artisan key:generate```
6. **Run Database Migration and Seeder:** ```./vendor/bin/sail artisan migrate:fresh --seed```
7. **Create Storage Symlink:** ```./vendor/bin/sail artisan storage:link```
8. **Install NPM Dependencies:** ```./vendor/bin/sail npm install```
9. **Built Frontend Assets:** ```./vendor/bin/sail npm run-script build```
10. **Access the Application:** Voltage should now be accessible at 127.0.0.1

## 🚧 Development Status

**Voltage** is currently in active development. As such, some bugs and issues are to be expected.

For a list of known issues and bugs, as well as any planned enhancements, please refer to the [Issues](https://github.com/sjwatts119/voltage/issues) tab.

## 🧑‍💻 Authors & Contributors

- **Sam Watts** - [@sjwatts119](https://github.com/sjwatts119)
