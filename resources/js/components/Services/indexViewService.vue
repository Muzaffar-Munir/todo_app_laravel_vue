<template>
  <div>
    <view-services-component :type="'website'"></view-services-component>
  </div>
</template>
<script>
import viewServicesComponent from "./viewServices";
export default {
  components: {
    viewServicesComponent,
  },
};
</script>