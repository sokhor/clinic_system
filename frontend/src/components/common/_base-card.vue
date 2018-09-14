<script>
export default {
  name: 'BaseCard',
  functional: true,
  render(h, context) {
    return (
      <div
        class="w-full bg-white shadow rounded overflow-hidden"
        {...{ class: context.data.staticClass }}
      >
        {context.children}
      </div>
    )
  }
}
</script>
