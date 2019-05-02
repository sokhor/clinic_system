export default {
  name: 'BaseTittle',
  functional: true,
  render: (h, context) => (
    <h1 class="inline text-gray-700 text-xl font-bold">{context.children}</h1>
  )
}
