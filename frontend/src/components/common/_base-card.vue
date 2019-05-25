<script>
export default {
  name: 'BaseCard',
  functional: true,
  render(h, context) {
    return (
      <div
        {...{
          class: ['card', context.data.staticClass]
        }}
      >
        {context.children}
      </div>
    )
  }
}
</script>
