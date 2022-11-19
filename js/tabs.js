window.addEventListener("DOMContentLoaded", () => {
	const tabLists = document.querySelectorAll('[role="tablist"]');

	let tabPanelIndex = 0;

	tabLists.forEach((tabList) => {
		const span = tabList.querySelector("span");
		span.setAttribute("style", "display:none");
		tabList.setAttribute("aria-labelledby", span.id);

		const tabs = tabList.querySelectorAll('[role="tab"]');

		let tabIndex = 0;
		// Add a click event handler to each tab
		tabs.forEach((tab) => {
			const tabPanels =
				tabList.parentElement.parentElement.querySelectorAll(
					'[role="tabpanel"]'
				);

			const tabPanel = tabPanels[tabPanelIndex];

			if (tabIndex === 0) {
				tab.setAttribute("aria-selected", true);
				tab.setAttribute("tabIndex", 0);

				tabPanel.setAttribute("tabIndex", 0);
			} else {
				tab.setAttribute("aria-selected", false);
				tab.setAttribute("tabIndex", -1);

				tabPanel.setAttribute("style", "display:none;");
			}

			tab.setAttribute("aria-controls", tabPanel.id);
			tabPanel.setAttribute("aria-labelledby", tab.id);
			tabPanel.setAttribute("tabIndex", 0);

			tab.addEventListener("click", changeTabs);

			tabIndex++;
			tabPanelIndex++;
		});

		// Enable arrow navigation between tabs in the tab list
		let tabFocus = 0;

		tabList.addEventListener("keydown", (e) => {
			// Move right
			if (e.keyCode === 39 || e.keyCode === 37) {
				tabs[tabFocus].setAttribute("tabindex", -1);
				if (e.keyCode === 39) {
					tabFocus++;
					// If we're at the end, go to the start
					if (tabFocus >= tabs.length) {
						tabFocus = 0;
					}
					// Move left
				} else if (e.keyCode === 37) {
					tabFocus--;
					// If we're at the start, move to the end
					if (tabFocus < 0) {
						tabFocus = tabs.length - 1;
					}
				}

				tabs[tabFocus].setAttribute("tabindex", 0);
				tabs[tabFocus].focus();
			}
		});
	});
});

function changeTabs(e) {
	const target = e.target;
	const parent = target.parentNode;
	const grandparent = parent.parentNode;

	// Remove all current selected tabs
	parent
		.querySelectorAll('[aria-selected="true"]')
		.forEach((t) => t.setAttribute("aria-selected", false));

	// Set this tab as selected
	target.setAttribute("aria-selected", true);

	// Hide all tab panels
	grandparent
		.querySelectorAll('[role="tabpanel"]')
		.forEach((p) => p.setAttribute("style", "display:none;"));

	// Show the selected panel
	grandparent.parentNode
		.querySelector(`#${target.getAttribute("aria-controls")}`)
		.removeAttribute("style");
}
