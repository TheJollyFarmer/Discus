<template>
  <v-field 
    grouped 
    class="filters">
    <v-select
      v-model="perPage"
      :options="perPageOptions"
      icon="comments"/>
    <v-select
      v-model="orderBy"
      :options="orderByOptions"
      icon="sort"/>
    <v-paginator
      v-model="page"
      :data-set="paginator"/>
  </v-field>
</template>

<script>
import constants from "../../constants/CommentFilters";
import VField from "../utility/VField";
import VPaginator from "../utility/paginator/VPaginator";
import VSelect from "../utility/VSelect";
import { mapActions, mapState } from "vuex";

export default {
  name: "ThreadFilters",

  components: { VField, VPaginator, VSelect },

  data() {
    return {
      perPageOptions: constants.perPageOptions,
      orderByOptions: constants.orderByOptions
    };
  },

  computed: {
    ...mapState("threads/thread/comments/paginator", [
      "paginator",
      "requestForm"
    ]),

    page: {
      get() {
        return this.requestForm.page;
      },

      set(value) {
        this.updatePage(value);
      }
    },

    perPage: {
      get() {
        return this.requestForm.perPage;
      },

      set(value) {
        this.updatePerPage(value);
      }
    },

    orderBy: {
      get() {
        return this.requestForm.orderBy;
      },

      set(value) {
        this.updateOrderBy(value);
      }
    }
  },

  methods: {
    ...mapActions("threads/thread/comments/paginator", [
      "updatePage",
      "updatePerPage",
      "updateOrderBy"
    ]),

    fetchEvent(page) {
      this.$emit("fetch", page);
    }
  }
};
</script>

<style lang="scss">
.filters {
  margin-bottom: 0.75rem;
  .pagination {
    margin-left: auto;
  }
  select {
    border-color: #00d1b2;
  }
  .control {
    .select::after {
      border-color: #00d1b2;
    }
    .icon {
      color: #00d1b2;
    }
  }
}
</style>
