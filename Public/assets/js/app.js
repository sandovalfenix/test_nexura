import { createApp } from 'vue';

const app = createApp({
  data() {
    return {
      Employees: [],
      Employee: {},
      Areas: [],
      Roles: [],
      alert: {},
    };
  },
  mounted() {
    this.listEmployees();
    this.listAreas();
    this.listRoles();
  },
  methods: {
    listEmployees: async function () {
      let url = '/Employees/list';
      let response = await fetch(url);
      this.Employees = await response.json();
    },
    listAreas: async function () {
      let url = '/Employees/listAreas';
      let response = await fetch(url);
      this.Areas = await response.json();
    },
    listRoles: async function () {
      let url = '/Employees/listRoles';
      let response = await fetch(url);
      this.Roles = await response.json();
    },
    readEmployee: async function (id) {
      let url = '/Employees/read?id=' + id;
      let response = await fetch(url);
      this.Employee = await response.json();
      console.log(this.Employee);
    },
    addEmployee: async function () {
      const form = document.getElementById('addEmployee');
      const data = new FormData(form);
      let url = '/Employees/add';
      let response = await fetch(url, {
        method: 'POST',
        body: data,
      });
      this.alert = await response.json();
      this.addRolesEmployee(this.alert.id);
      this.listEmployees();
    },
    addRolesEmployee: async function (id) {
      const form = document.getElementById('rolesEmployee');
      const data = new FormData(form);
      let url = '/Employees/addRolesEmployee?empleado_id=' + id;
      let response = await fetch(url, {
        method: 'POST',
        body: data,
      });

      console.log(await response.json());
    },
    deleteEmployee: async function (id, index) {
      let url = '/Employees/delete?id=' + id;
      let response = await fetch(url);
      this.alert = await response.json();
      this.listEmployees();
    },
  },
});

app.mount('#app');
