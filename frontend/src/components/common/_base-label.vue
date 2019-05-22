<script>
export default {
  name: 'BaseLabel',
  functional: true,
  render(h, context) {
    return (
      <label
        {...{
          class: ['form-label', context.data.staticClass],
          attrs: context.data.attrs
        }}
      >
        {context.children}
      </label>
    )
  }
}
</script>
