<template>
  <v-search :model="model">
    <ais-search-box>
      <template #default="{ currentRefinement, refine }">
        <slot
          :currentRefinement="currentRefinement"
          :refine="refine"/>
      </template>
    </ais-search-box>
    <ais-hits #default="{ items }">
      <slot
        name="hits"
        :hits="items"/>
    </ais-hits>
  </v-search>
</template>

<script>
import VSearch from "./VSearch";
import { AisHits, AisSearchBox } from "vue-instantsearch";

export default {
  name: "VHits",

  components: { VSearch },

  props: {
    model: {
      type: String,
      required: true
    }
  }
};
</script>
