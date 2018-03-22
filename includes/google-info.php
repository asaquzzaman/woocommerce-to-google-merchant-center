<?php 

function woogool_google_category() {
	ob_start();
	?>
	<table class="wide nice-table" width="200">
	  	<thead>
		    <tr>
				<th>Attribute</th>
				<th>Format</th>
		    </tr>
	  	</thead>
		<tbody>
			<tr>
			  <td style="width:15%;"><code><a name="google_product_category"></a><a href="/merchants/answer/6324436" target="_blank">google_​​product_​​category</a></code></td>
			  <td style="width:30%;">
			  <p><span class="red-text"><strong>Required</strong> (for&nbsp;<code>Apparel &amp; Accessories </code>(<code>166</code>), <code>Media</code> (<code>783</code>), and <code>Software</code> (<code>2092</code>) categories)</span><br>
			    Google-defined product category for your product</p>

			  <p><strong>Example</strong><br>
			    <code>Apparel &amp; Accessories &gt; Clothing &gt; Outerwear &gt; Coats &amp; Jackets</code><br>
			    or<br>
			    <code>371</code></p>

			  <p><strong>Syntax</strong><br>
			    Value from the Google product taxonomy</p>

			  <ul>
			    <li>The numerical category ID, or</li>
			    <li>The full path of the category</li>
			  </ul>

			  <p><strong>Supported values</strong><br>
			    <a href="/merchants/answer/1705911">Google product taxonomy</a></p>
			  </td>
			 
			</tr>
		</tbody>
	</table>
	<?php
	return ob_get_clean();
}