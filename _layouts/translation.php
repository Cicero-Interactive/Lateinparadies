---
layout: wrapper
---

<!-- Process chapters, add missing information -->
{% assign page.chapters = page.chapters | process_chapters %}


<main>
	<!-- Include heading with chapter links -->
	{% include translation-heading.php %}

	<div style="margin: auto">
		{% if page.chapters == nil %}
			<div class="alert alertYellow" style="max-width: 600px; margin: -30px auto 10px auto;">Diese Seite Seite ist momentan im Aufbau. Versuche es bitte in ein paar Tagen erneut!</div>
		{% endif %}

		{% for chapter in page.chapters %}
			<!-- Set ID to be able to be linked from above -->
			<div {% if chapter.display-name %}id="Ch{{ chapter.number }}"{% endif %} class="chapter">
				{% if chapter.display-name %}
					<h2>{{ chapter.display-name }}</h2>
				{% endif %}

				<!-- If chapter is basic chapter -->
				{% if chapter.latin and chapter.german %}
					<div class="chapter-item">
						<p>
							{{ chapter.latin }}
						</p>
						<div></div>
						<p>
							{{ chapter.german }}
							{% if chapter.footnotes != nil %}
								<br><br>
								<span class="footnotes">
									{% for footnote in chapter.footnotes %}
										<sup>{{ footnote.number }}</sup>: {{ footnote.content }}<br>
									{% endfor %}
								</span>
							{% endif %}
						</p>
					</div>

				<!-- If chapter consists of multiple sections -->
				{% elsif chapter.sections %}
					{% assign poemLine = -1 %}
					{% for section in chapter.sections %}
						<!-- If section contains translations -->
						{% if section.type == nil or section.type == "translation" %}
							<!-- If section is a poem -->
							{% if section.style == "poem" or section.style == nil and chapter.style == "poem" %}
								{% if section.number  == nil %}
									{% assign poemLine = poemLine | plus: 2 %}
								{% else %}
									{% assign poemLine = section.number %}
								{% endif %}

								{% if chapter.poem-style == nil or chapter.poem-style == "wide" %}
									{% assign suffix = "<span class='ShowOnBigScreen'></span>" %}
								{% elsif chapter.poem-style == "thin" %}
									{% assign suffix = "<br>" %}
								{% endif %}
								<div class="poem-item">
									<p>
										{{ poemLine }}
									</p>
									<div></div>
									<p>
										{{ section.latin | newline_to_br | replace: "<br />", suffix }}
									</p>
									<div></div>
									<p>
										{{ section.german | newline_to_br | replace: "<br />", suffix }}
									</p>
								</div>
							<!-- If section is a poem verse seperator -->
							{% elsif section.style == "verse-seperator" %}
								<div class="poem-item verse-seperator">
									<p></p>
									<div></div>
									<p></p>
									<div></div>
									<p></p>
								</div>
							<!-- If section indicates missing of verse(s) -->
							{% elsif section.style == "verse-missing" %}
								<div class="poem-item verse-missing">
									<p></p>
									<div></div>
									<p></p>
									<div></div>
									<p></p>
								</div>
							<!-- If section is default chapter-based -->
							{% elsif section.style == nil or section.style == "default" %}
								<div class="chapter-item">
									<p>
										{{ section.latin }}
									</p>
									<div></div>
									<p>
										{{ section.german }}
										{% if chapter.footnotes != nil %}
											<br><br>
											<span class="footnotes">
												{% for footnote in section.footnotes %}
													<sup>{{ footnote.number }}</sup>: {{ footnote.content }}<br>
												{% endfor %}
											</span>
										{% endif %}
									</p>
								</div>
							{% endif %}
						<!-- If section contains sidestory -->
						{% elsif section.type == "story" %}
							<div class="story"><hr>{{ section.content }}<hr></div>
						{% endif %}
					{% endfor %}
				{% endif %}

			</div>
			<!-- Spacing on the bottom of the page -->
			{% unless chapter.latin == page.chapters.last.latin %}
				<br><br>
			{% endunless %}
		{% endfor %}
	</div>
</main>
{% include translation-sources.php %}