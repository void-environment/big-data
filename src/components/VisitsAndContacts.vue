<template>

  <div>

    <div v-for="visit in visits" :key="visit.id" @click="getContacts(visit.id)" class="visit">

      <p>ID: {{ visit.id }}</p>
      <p>Page: {{ visit.page }}</p>
      <p>IP: {{ visit.ip }}</p>
      <p>User Agent: {{ visit.user_agent }}</p>
      <p>Browser: {{ visit.browser }}</p>
      <p>Device: {{ visit.device }}</p>
      <p>Platform: {{ visit.platform }}</p>
      <p>Created At: {{ visit.created_at }}</p>

    </div>

    <dialog ref="contactDialog">

      <h2>Контакты по визиту ID: {{ visitId }}</h2>
      <div v-for="contact in contacts" :key="contact.id">
        <p>Почта: {{ contact.email }}</p>
        <p>Телефон: {{ contact.phone }}</p>
      </div>
      <button @click="closeDialog">Закрыть</button>

    </dialog>

  </div>
</template>

<script>
export default {

  data() {
    return {
      visits: [],
      contacts: [],
      visitId: null,
      domain: 'https://litec-soft.ru/big-data'
    };
  },

  methods: {
    
    getVisits() {
      fetch(`${this.domain}/api/v1/visit/`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      })
      .then((response) => response.json())
      .then((data) => {
        this.visits = data.visits || [];
      })
    },

    getContacts(visitId) {
      this.visitId = visitId;

      fetch(`${this.domain}/api/v1/contact/?visitId=${visitId}`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          this.contacts = data.contacts || [];
          this.openDialog();
        })
        .catch((error) => {
          console.error("Error fetching contacts:", error);
        });
    },

    openDialog() {
      this.$refs.contactDialog.showModal();
    },

    closeDialog() {
      this.$refs.contactDialog.close();
    },
  },

  mounted() {
    this.getVisits();
  },
};
</script>

<style>

.visit {
  padding: 10px;
  margin-bottom: 10px;

  border: 1px solid #ccc;
  cursor: pointer;
}
.visit:active {
  background-color: #f9f9f9;
}

dialog {
  padding: 20px;
  margin: 0 auto;
  top: 50%;

  transform: translateY(-50%);

  border: none;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
dialog h2 {
  margin-bottom: 15px;
}

button{
  margin-top: 20px;
}

</style>
