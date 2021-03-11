# jquery.simple.accordion

## Usage

```html
<ul class="ac">
	<li>
		<a href="/lv1/">lv1</a>
		<ul>
			<li>
				<a href="/lv2/">lv2</a>
				<ul>
					<li><a href="/lv3/">lv3</a></li>
				</ul>
			</li>
		</ul>
	</li>
</ul>
```

```js
$('.ac').simpleAccordion({
	useLinks: false // false: Remove href, if list has child.
});
```
