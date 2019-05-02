export default {
  name: 'BaseUserIcon',
  functional: true,
  render: (h, context) => (
    <svg
      version="1.1"
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 32 32"
      {...{ class: ['fill-current text-gray-600', context.data.staticClass] }}
    >
      <circle cx="16" cy="7.5" r="7.4" />
      <path d="M16,18C7.7,18,1,24.3,1,32h30C31,24.3,24.3,18,16,18z" />
    </svg>
  )
}
