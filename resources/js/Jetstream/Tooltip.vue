<template>
  <div class="tooltip-box">
    <slot />
    <div
      :class="['tooltip', position]"
    >
      <span
        class="text"
      >
            {{ text }}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  props: { 
    text: {
      type: String,
      required: true
    },
    position: {
        type: String,
        default: 'left'
    }
  }
};
</script>

<style scoped>
.tooltip-box { 
  position: relative;
  display: inline-block;
}

.tooltip-box:hover .tooltip{
  opacity: 1;
}

.tooltip { 
  color: #ffffff;
  text-align: center;
  padding: 5px;
  border-radius: 2px;
  width: 120px;
  opacity: 0;
  transition: opacity 0.4s;
  position: absolute;
  z-index: 1;
  background: #000;
}

.left {
    top: 50%;
    right: 100%;
    transform: translateY(-50%);
    margin-right: 10px;
}

</style>