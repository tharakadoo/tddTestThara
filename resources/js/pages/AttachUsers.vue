<template>
  <div class="p-6">
    <h2 class="text-xl font-bold mb-4">Subscribe to Website</h2>

    <div class="mb-4">
      <label class="block font-semibold">Select Website:</label>
      <select v-model="selectedWebsite" class="border p-2">
        <option v-for="website in websites" :key="website.id" :value="website.id">
          {{ website.url }}
        </option>
      </select>
    </div>

    <div class="mb-4">
      <label class="block font-semibold">Select Users:</label>
      <div v-for="user in users" :key="user.id">
        <input type="checkbox" :value="user.id" v-model="selectedUsers" />
        {{ user.name }} ({{ user.email }})
      </div>
    </div>

    <!-- Dynamic Message Box -->
    <div v-if="message"
     :class="['mt-4 mb-4', messageType === 'success' ? 'success-message-box' : 'error-message-box']"
        v-html="message">
    </div>

    <button @click="attachUsers" class="bg-blue-500 text-white px-4 py-2 rounded">
      Subscribe
    </button>

  </div>
</template>

<script>
import '../../css/subscribe.css';
import axios from 'axios';

export default {
  data() {
    return {
      websites: [],
      users: [],
      selectedWebsite: null,
      selectedUsers: [],
      message: '',
      messageType: '', // 'success' or 'error'
    };
  },
  mounted() {
    this.fetchWebsites();
    this.fetchUsers();
  },
  methods: {
    async fetchWebsites() {
      const res = await axios.get('/api/websites');
      this.websites = res.data;
    },
    async fetchUsers() {
      const res = await axios.get('/api/users');
      this.users = res.data;
    },
    async attachUsers() {
      if (!this.selectedWebsite || this.selectedUsers.length === 0) {
            this.showError('Please select a website and at least one user');
            return;
      }

      try {
            const res = await axios.post(`/api/websites/users`, {
                    website: this.selectedWebsite,
                    user_ids: this.selectedUsers
                });
            this.showSuccess(res.data.message || 'Users subscribed successfully');
            this.selectedWebsite = null;
            this.selectedUsers = [];
        } catch (err) {
            console.error(err);

            if (err.response?.data?.errors) {
                const allErrors = Object.values(err.response.data.errors)
                    .flat()
                    .join('<br>');
                    this.showError(allErrors, true);
            } else {
                this.showError(err.response?.data?.message || 'Error attaching users');
            }
        }
    },
    showSuccess(msg) {
      this.message = msg;
      this.messageType = 'success';
      this.autoClear();
    },
    showError(msg, isHtml = false) {
        this.messageType = 'error';
        if (isHtml) {
            this.message = msg; // already contains <br>
        } else {
            this.message = msg;
        }
        this.autoClear();
    },
    autoClear() {
      setTimeout(() => {
        this.message = '';
        this.messageType = '';
      }, 4000); // clears after 4 seconds
    }
  }
};
</script>

<style scoped>
.success-message-box {
  padding: 0.75rem 1rem;
  background-color: #dcfce7; /* light green */
  color: #166534; /* dark green */
  border-radius: 6px;
  font-weight: 500;
  text-align: center;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.error-message-box {
  padding: 0.75rem 1rem;
  background-color: #fee2e2; /* light red */
  color: #b91c1c; /* dark red */
  border-radius: 6px;
  font-weight: 500;
  text-align: center;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
</style>
