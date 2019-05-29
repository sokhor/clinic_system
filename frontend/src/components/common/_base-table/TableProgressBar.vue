<script>
export default {
  name: 'TableProgressBar',
  functional: true,
  render(createElement, context) {
    return createElement('tr', context.data, [
      createElement(
        'th',
        {
          class: 'table-data-loading',
          attrs: {
            colspan: context.parent.columnLength
          }
        },
        [
          createElement(
            'div',
            {
              class: 'table-data-loading__slider'
            },
            [
              createElement('div', { class: 'table-data-loading__line' }),
              createElement('div', {
                class: [
                  'table-data-loading__subline',
                  'table-data-loading__subline__inc'
                ]
              }),
              createElement('div', {
                class: [
                  'table-data-loading__subline',
                  'table-data-loading__subline__dec'
                ]
              })
            ]
          )
        ]
      )
    ])
  }
}
</script>
