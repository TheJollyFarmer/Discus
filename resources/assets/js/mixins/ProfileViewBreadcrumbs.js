import breadcrumbs from "../constants/Breadcrumbs";
import { mapActions, mapState } from "vuex";

export default {
  computed: mapState("auth", ["breadcrumb"]),

  created() {
    this.addBreadcrumbs([
      this.breadcrumb.users,
      this.breadcrumb.user,
      breadcrumbs[this.breadcrumbType]
    ]);
  },

  methods: mapActions(["addBreadcrumbs"])
};
