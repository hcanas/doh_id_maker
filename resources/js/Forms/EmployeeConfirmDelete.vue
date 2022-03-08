<template>
  <div class="flex flex-col space-y-8">
    <h1 class="text-xl font-bold pb-4 border-b">Employee Deletion</h1>
    <div class="flex flex-col space-y-2">
      <span>{{ data.code }}</span>
      <span>{{ data.family_name + ', ' + data.given_name + ' ' + (data.middle_name ?? '') + ' ' + (data.name_suffix ?? '') }}</span>
      <span>{{ data.position }}</span>
    </div>
    <div class="flex justify-between items-center pt-4">
      <breeze-button-light :type="'button'" @click="$emit('cancel')">Cancel</breeze-button-light>
      <breeze-button-danger :type="'button'" @click="deleteEmployee">Save</breeze-button-danger>
    </div>
  </div>
</template>

<script>
  import BreezeButtonLight from '@/Components/ButtonLight.vue';
  import BreezeButtonDanger from '@/Components/ButtonDanger.vue';

  export default {
    name: "EmployeeConfirmDelete",
    props: {
      data: Object,
    },
    components: {
      BreezeButtonLight,
      BreezeButtonDanger,
    },
    methods: {
      deleteEmployee() {
        axios.delete(`/api/employees/${this.data.id}`)
        .then(() => this.$emit('deletedEmployee', this.data.id))
        .catch();
      },
    },
  }
</script>

<style scoped>

</style>