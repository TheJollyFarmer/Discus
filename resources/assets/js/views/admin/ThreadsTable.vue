<template>
  <v-table>
    <v-t-head :header="header"/>
    <v-t-body data="threads"/>
  </v-table>
</template>

<script>
import VTable from "../../components/utility/VTable";
import VTBody from "../../components/utility/VTBody";
import VTHead from "../../components/utility/VThead";

export default {
  name: "ThreadsTable",

  components: { VTable, VTBody, VTHead },

  data() {
    return {
      header: ["Title", "Body", "Author", "Actions"]
    };
  }
};
</script>

<style scoped>
</style>
