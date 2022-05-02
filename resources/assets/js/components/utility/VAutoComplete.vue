<template>
  <ais-autocomplete :indices="indices">
    <template #default="{ currentRefinement, indices, refine }">
      <div class="is-clipped">
        <v-input
          v-model="currentRefinement"
          :validation="false"
          :class="inputActiveClass"
          :placeholder="placeholderText"
          type="search"
          icon-left="search"
          @input="refine"
          @blur="toggleDropdown"
          @focus="toggleDropdown"
          @typing="clearSelectedItemEvent($event, indices)"
          @keyDown="itemSelectedEvent($event, indices)"
          @keyUp="itemSelectedEvent($event, indices)"
          @onEnter="loadItemEvent(indices)"/>
      </div>
      <transition-expand>
        <div
          v-show="currentRefinement && isActive"
          :class="classes">
          <slot
            v-if="indices.length > 1"
            :indices="indices"/>
          <slot
            v-else
            :index="indices[0].hits"/>
        </div>
      </transition-expand>
    </template>
  </ais-autocomplete>
</template>

<script>
import { AisAutocomplete } from "vue-instantsearch";
import Dropdown from "../../mixins/Dropdown";
import TransitionExpand from "../transitions/TransitionExpand";
import VInput from "./VInput";

export default {
  name: "VAutoComplete",

  components: { AisAutocomplete, TransitionExpand, VInput },

  mixins: [Dropdown],

  props: {
    indices: {
      type: Array,
      required: true
    },

    classes: {
      type: String,
      required: false,
      default: "search-dropdown"
    }
  },

  computed: {
    inputActiveClass() {
      return this.isActive ? "inputActive" : "inputNotActive";
    },

    placeholderText() {
      return this.isActive ? "Search for users and threads..." : "";
    }
  },

  methods: {
    itemSelectedEvent(direction, indices) {
      this.$emit("itemSelected", direction, this.calcHitTotal(indices));
    },

    clearSelectedItemEvent(e, indices) {
      if (e.which !== 38 && e.which !== 40) {
        this.$emit("clearItem", this.calcHitTotal(indices));
      }
    },

    loadItemEvent(indices) {
      let hits = indices[0].hits.concat(indices[1].hits);

      this.$emit("loadItem", hits);
    },

    calcHitTotal(indices) {
      if (indices.length > 1) {
        return indices[0].hits.length + indices[1].hits.length;
      }

      return indices[0].hits.length;
    }
  }
};
</script>

<style lang="scss" scoped>
.search-dropdown {
  background-color: white;
  border-bottom-left-radius: 6px;
  border-bottom-right-radius: 6px;
  border-top: 2px solid #dbdbdb;
  box-shadow: 0 8px 8px rgba(10, 10, 10, 0.1);
  color: black;
  font-size: 0.875rem;
  left: 0;
  max-height: 35.8em;
  padding: 0.5rem 0;
  position: absolute;
  top: 122%;
  width: 100%;
  z-index: 20;
}

.inputActive {
  transition: all 0.3s ease-in-out;
  width: 24em;
}

::v-deep .inputNotActive {
  width: 25px;
  transition: width 0.3s ease-in-out;
  input {
    background-color: transparent;
    border: none;
    box-shadow: none;
    cursor: pointer;
    transition-property: width;
  }
  .icon {
    color: white;
    width: 1.5em;
  }
}
</style>
