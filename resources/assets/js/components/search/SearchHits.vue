<template>
  <v-hits :model="model">
    <template #default="{ currentRefinement, refine }">
      <v-field>
        <v-input
          v-model="currentRefinement"
          type="search"
          placeholder="Search for users..."
          icon-left="search"
          icon-right="times-circle"
          @input="refine"/>
      </v-field>
    </template>
    <template #hits="{ hits }">
      <slot :hits="hits"/>
    </template>
  </v-hits>
</template>

<script>
import VField from "../utility/VField";
import VHits from "../utility/VHits";
import VInput from "../utility/VInput";

export default {
  name: "SearchHits",

  components: {
    VField,
    VHits,
    VInput
  },

  props: {
    model: {
      type: String,
      required: false,
      default: "users"
    }
  }
};
</script>

<style scoped>
::v-deep .ais-Hits {
  display: flex;
  flex: 1;
  flex-direction: column;
  margin-top: 0.3em;
}
</style>
