<template>
  <ul>
    <li
      v-for="(item, index) in items"
      :key="index"
      :class="{ 'is-active': isActiveTab(item.name) }"
      @click="selectTab(item.name)">
      <a>
        <v-favicon :icon="item.icon"/>
      </a>
    </li>
  </ul>
  </div>
</template>

<script>
import VFavicon from "./VFavicon";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "VIconList",

  components: { VFavicon },

  props: {
    items: {
      type: Object,
      required: true
    }
  },

  computed: mapGetters(["isActiveTab"]),
  methods: mapActions(["selectTab"])
};
</script>
