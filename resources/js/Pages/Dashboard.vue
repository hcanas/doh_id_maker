<template>
  <head title="Employees"/>

  <breeze-authenticated-layout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Employees
        </h2>
        <breeze-button @click="newEmployeeForm">
          New Employee
        </breeze-button>
      </div>
    </template>

    <div class="py-12">
      <div class="w-full sm:px-8 lg:px-24">
        <div class="bg-white overflow-hidden shadow-sm">
          <ag-grid-vue style="width: 100%; height: 74vh;"
          class="ag-theme-alpine"
          @grid-ready="gridReady"
          @cell-clicked="gridCellClicked"
          :getRowNodeId="data => data.id"
          :columnDefs="column_defs"
          :rowData="[]"
          rowSelection="single"
          pagination="true"
          paginationPageSize="25"
          >
          </ag-grid-vue>
        </div>
      </div>
    </div>
  </breeze-authenticated-layout>

  <modal :show="modal.show">
    <component :is="modal.component" :data="modal.data" @created-employee="createdEmployee" @updated-employee="updatedEmployee" @deleted-employee="deletedEmployee" @cancel="closeModal" />
  </modal>
</template>

<script>
  import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
  import { Head } from '@inertiajs/inertia-vue3';
  import BreezeInput from '@/Components/Input.vue';
  import BreezeLabel from '@/Components/Label.vue';
  import BreezeButton from '@/Components/Button.vue';
  import Modal from '@/Components/Modal.vue';
  import EmployeeForm from "@/Forms/EmployeeForm.vue";
  import EmployeeConfirmDelete from "@/Forms/EmployeeConfirmDelete.vue";

  import "ag-grid-community/dist/styles/ag-grid.css";
  import "ag-grid-community/dist/styles/ag-theme-alpine.css";
  import { AgGridVue } from "ag-grid-vue3";

  import { ref, reactive } from 'vue';

  export default {
    name: 'Dashboard',
    components: {
      BreezeAuthenticatedLayout,
      Head,
      AgGridVue,
      BreezeLabel,
      BreezeInput,
      BreezeButton,
      Modal,
      EmployeeForm,
      EmployeeConfirmDelete,
    },
    setup() {
      const grid_api = ref(null);
      const modal = reactive({
        show: false,
        component: '',
        data: null,
      });

      axios.get('/api/auth')
      .then(response => console.log(response.data))
      .catch(error => console.log(error.response.data));

      const column_defs = [
        {
          cellRenderer: params => '<div class="flex items-center space-x-4">' +
            '<button class="group" data-action="view_id"><i class="fas fa-id-card group-hover:text-sky-600" data-action="view_id"></i></button>' +
            '<button class="group" data-action="edit"><i class="fas fa-pencil group-hover:text-amber-600" data-action="edit"></i></button>' +
            '<button class="group" data-action="delete"><i class="fas fa-trash group-hover:text-red-600" data-action="delete"></i></button>' +
            '</div>',
          width: 100,
        },
        {
          headerName: 'Photo',
          cellRenderer: params => `<img src="storage/photos/${params.data.photo ?? 'placeholder.png'}" style="width: 100px; height: 100px;">`,
          wrapText: true,
          width: 150,
          autoHeight: true,
        },
        {
          headerName: 'Code',
          field: "code",
          sortable: true,
          filter: true,
          width: 150,
        },
        {
          headerName: "Name",
          resizable: true,
          sortable: true,
          filter: true,
          width: 300,
          valueGetter: params => `${params.data.family_name}, ${params.data.given_name} ${params.data.middle_name ?? ''} ${params.data.name_suffix ?? ''}`,
        },
        {
          headerName: 'Address',
          field: "address",
          wrapText: true,
          resizable: true,
          sortable: true,
          filter: true,
          width: 300,
          autoHeight: true,
        },
        {
          headerName: 'Contact #',
          field: "contact_number",
          resizable: true,
          sortable: true,
          filter: true,
          width: 200,
        },
        {
          headerName: 'Email',
          field: "email",
          resizable: true,
          sortable: true,
          filter: true,
          width: 250,
        },
        {
          headerName: 'Position',
          field: "position",
          resizable: true,
          sortable: true,
          filter: true,
          width: 300,
        },
        {
          headerName: 'Birth Date',
          field: "birth_date",
          resizable: true,
          sortable: true,
          filter: 'agDateColumnFilter',
          width: 200,
        },
        {
          headerName: 'Sex',
          field: "sex",
          resizable: true,
          sortable: true,
          filter: true,
          width: 200,
        },
        {
          headerName: 'Blood Type',
          field: "blood_type",
          resizable: true,
          sortable: true,
          filter: true,
          width: 200,
        },
        {
          headerName: 'GSIS',
          field: "gsis_number",
          resizable: true,
          sortable: true,
          filter: true,
          width: 200,
        },
        {
          headerName: 'Pag-IBIG',
          field: "pagibig_number",
          resizable: true,
          sortable: true,
          filter: true,
          width: 200,
        },
        {
          headerName: 'Philhealth',
          field: "philhealth_number",
          resizable: true,
          sortable: true,
          filter: true,
          width: 200,
        },
        {
          headerName: 'TIN',
          field: "tin_number",
          resizable: true,
          sortable: true,
          filter: true,
          width: 200,
        },
        {
          headerName: 'Emergency Contact',
          field: "emergency_contact",
          resizable: true,
          sortable: true,
          filter: true,
          width: 200,
        },
        {
          headerName: 'Emergency Contact #',
          field: "emergency_contact_number",
          resizable: true,
          sortable: true,
          filter: true,
          width: 200,
        },
        {
          headerName: 'Active From',
          field: "active_from",
          resizable: true,
          sortable: true,
          filter: 'agDateColumnFilter',
          width: 200,
        },
        {
          headerName: 'Active To',
          field: "active_to",
          resizable: true,
          sortable: true,
          filter: 'agDateColumnFilter',
          width: 200,
        },
      ];

      const gridReady = params => {
        grid_api.value = params.api;

        fetch('/api/employees')
          .then(response => response.json())
          .then(data => {
            grid_api.value.applyTransaction({
              add: data,
              addIndex: 0,
            });
          });
      };

      const gridCellClicked = params => {
        switch (params.event.target.dataset.action) {
          case 'view_id':
            window.open(`/cards/${params.data.id}`, '_blank').focus();
            break;

          case 'edit':
            modal.show = true;
            modal.component = 'employee-form';
            modal.data = params.data;
            break;

          case 'delete':
            modal.show = true;
            modal.component = 'employee-confirm-delete';
            modal.data = params.data;
            break;
        }
      };

      const newEmployeeForm = () => {
        modal.show = true;
        modal.component = 'employee-form';
      };

      const createdEmployee = employee => {
        grid_api.value.applyTransaction({
          add: [employee],
          addIndex: 0,
        });

        closeModal();
      };

      const updatedEmployee = employee => {
        grid_api.value.applyTransaction({ update: [employee] });

        closeModal();
      };

      const deletedEmployee = id => {
        grid_api.value.applyTransaction({ remove: [{ id }] });

        closeModal();
      };

      const closeModal = () => {
        modal.show = false;
        modal.component = '';
        modal.data = null;
      };

      return {
        modal,
        grid_api,
        column_defs,
        gridReady,
        gridCellClicked,
        newEmployeeForm,
        createdEmployee,
        updatedEmployee,
        deletedEmployee,
        closeModal,
      };
    },
  };
</script>