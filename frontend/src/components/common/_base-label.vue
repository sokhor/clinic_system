<script>
export default {
  name: 'BaseLabel',
  functional: true,
  render(h, context) {
    return (
      <label
        class="block text-grey-darker text-sm font-bold"
        {...{ class: context.data.staticClass }}
      >
        {context.children}
      </label>
    )
  }
}
</script>
