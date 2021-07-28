<template>
  <div>a</div>
</template>

<script>
import Api from "../../services/api";
export default {
  data() {
    return {};
  },

  async created() {
		let api = Api.new();
		api.getEntrie(this.$route.params.slug, this.$route.params.collection, this.$route.params.id).then(resp => {
			console.log(resp);
		})
	},
};
</script>

<style lang="scss" scoped>
</style>