<template>
  <div class="flex flex-col">
    <h1 class="text-xl font-bold pb-4 border-b">{{ form_data.id ? 'Update Employee' : 'Create Employee' }}</h1>

    <div class="py-8">
      <form @submit.prevent>
        <div class="flex flex-col space-y-4">
          <div class="flex flex-col">
            <breeze-label>Photo</breeze-label>
            <breeze-input type="file" @change="photoSelected" />
          </div>

          <div class="flex flex-col">
            <breeze-label>Code</breeze-label>
            <breeze-input type="text" v-model="form_data.code" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('code')">{{ form_errors.code[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Given Name</breeze-label>
            <breeze-input type="text" v-model="form_data.given_name" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('given_name')">{{ form_errors.given_name[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Middle Name</breeze-label>
            <breeze-input type="text" v-model="form_data.middle_name" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('middle_name')">{{ form_errors.middle_name[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Family Name</breeze-label>
            <breeze-input type="text" v-model="form_data.family_name" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('family_name')">{{ form_errors.family_name[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Name Suffix</breeze-label>
            <breeze-input type="text" v-model="form_data.name_suffix" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('name_suffix')">{{ form_errors.name_suffix[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Nickname</breeze-label>
            <breeze-input type="text" v-model="form_data.nickname" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('nickname')">{{ form_errors.nickname[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Address</breeze-label>
            <breeze-input type="text" v-model="form_data.address" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('address')">{{ form_errors.address[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Contact Number</breeze-label>
            <breeze-input type="text" v-model="form_data.contact_number" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('contact_number')">{{ form_errors.contact_number[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Email</breeze-label>
            <breeze-input type="text" v-model="form_data.email" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('email')">{{ form_errors.email[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Position</breeze-label>
            <breeze-input type="text" v-model="form_data.position" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('position')">{{ form_errors.position[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Birth Date</breeze-label>
            <breeze-input type="date" v-model="form_data.birth_date" class="w-full" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('birth_date')">{{ form_errors.birth_date[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Sex</breeze-label>
            <select v-model="form_data.sex" :class="'rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded outline-none'">
              <option value="Male" selected>Male</option>
              <option value="Female">Female</option>
            </select>
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('sex')">{{ form_errors.sex[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Blood Type</breeze-label>
            <breeze-input type="text" v-model="form_data.blood_type" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('blood_type')">{{ form_errors.blood_type[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>GSIS Number</breeze-label>
            <breeze-input type="text" v-model="form_data.gsis_number" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('gsis_number')">{{ form_errors.gsis_number[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Pag-IBIG Number</breeze-label>
            <breeze-input type="text" v-model="form_data.pagibig_number" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('pagibig_number')">{{ form_errors.pagibig_number[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Philhealth Number</breeze-label>
            <breeze-input type="text" v-model="form_data.philhealth_number" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('philhealth_number')">{{ form_errors.philhealth_number[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>TIN Number</breeze-label>
            <breeze-input type="text" v-model="form_data.tin_number" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('tin_number')">{{ form_errors.tin_number[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Emergency Contact</breeze-label>
            <breeze-input type="text" v-model="form_data.emergency_contact" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('emergency_contact')">{{ form_errors.emergency_contact[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Emergency Contact Number</breeze-label>
            <breeze-input type="text" v-model="form_data.emergency_contact_number" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('emergency_contact_number')">{{ form_errors.emergency_contact_number[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Active From</breeze-label>
            <breeze-input type="date" v-model="form_data.active_from" class="w-full" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('active_from')">{{ form_errors.active_from[0] }}</span>
          </div>

          <div class="flex flex-col">
            <breeze-label>Active To (leave blank for permanent staff)</breeze-label>
            <breeze-input type="date" v-model="form_data.active_to" class="w-full" />
            <span class="text-sm text-red-600" v-if="form_errors.hasOwnProperty('active_to')">{{ form_errors.active_to[0] }}</span>
          </div>

          <div class="flex justify-between items-center pt-4">
            <breeze-button-light :type="'button'" @click="cancel">Cancel</breeze-button-light>
            <breeze-button :type="'button'" @click="saveEmployee">Save</breeze-button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import { ref, reactive } from 'vue';

  import BreezeInput from '@/Components/Input.vue';
  import BreezeLabel from '@/Components/Label.vue';
  import Select from '@/Components/Select.vue';
  import BreezeButton from '@/Components/Button.vue';
  import BreezeButtonLight from '@/Components/ButtonLight.vue';

  export default {
    name: "EmployeeForm",
    components: {
      BreezeInput,
      BreezeLabel,
      Select,
      BreezeButton,
      BreezeButtonLight,
    },
    props: {
      data: Object,
    },
    setup(props, { emit }) {
      let photo = ref('');

      const form_data = reactive(props.data
        ? JSON.parse(JSON.stringify(props.data))
        : {
          code: null,
          given_name: null,
          middle_name: null,
          family_name: null,
          name_suffix: null,
          nickname: null,
          address: null,
          contact_number: null,
          email: null,
          position: null,
          birth_date: null,
          sex: 'Male',
          blood_type: null,
          gsis_number: null,
          pagibig_number: null,
          philhealth_number: null,
          tin_number: null,
          emergency_contact: null,
          emergency_contact_number: null,
          active_from: null,
          active_to: null,
        }
      );

      let form_errors = ref({});

      const cancel = () => {
        emit('cancel');
      };

      const saveEmployee = () => {
        const final_data = new FormData();

        for (const [key, value] of Object.entries(form_data)) {
          final_data.append(key, value ?? '');
        }

        final_data.append('photo', photo.value);

        if (form_data.id) {
          final_data.append('_method', 'put');

          axios.post(`api/employees/${form_data.id}`, final_data, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          })
          .then(response => emit('updatedEmployee', response.data))
          .catch(error => {
            if (typeof error.response.data === 'object') {
              form_errors.value = error.response.data;
            }
          });
        } else {
          axios.post('/api/employees', final_data, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          })
          .then(response => emit('createdEmployee', response.data))
          .catch(error => {
            if (typeof error.response.data === 'object') {
              form_errors.value = error.response.data;
            }
          });
        }
      };

      const photoSelected = event => {
        photo.value = event.target.files[0];
      };

      return {
        form_data,
        form_errors,
        cancel,
        saveEmployee,
        photoSelected,
      }
    },
  }
</script>